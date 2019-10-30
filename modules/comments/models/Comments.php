<?php

namespace modules\comments\models;

use Yii;
use \modules\comments\Module;
use common\components\behaviors\PurifyBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributesBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string $entity
 * @property int $entityId
 * @property string $content
 * @property int $parentId
 * @property int $level
 * @property string $creatorType
 * @property string $said_name
 * @property string $said_email
 * @property string $ip
 * @property int $createdBy
 * @property int $updatedBy
 * @property int $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class Comments extends ActiveRecord
{
    const CREATOR_TYPE_USER = 'user';
    const CREATOR_TYPE_GUEST = 'guest';
    
    
    const STATUS_PUBLIC = 1;
    const STATUS_DISABLED = 0;
    /**
     * @var null|array|ActiveRecord[] comment children
     */
    protected $children;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['parentId'], 'integer'],
            [['content'], 'string'],
            [['said_name', 'said_email'], 'string', 'max' => 255],
            
            [['like_count', 'entity', 'entityId', 'status', 'said_email', 'creatorType', 'createdAt', 'updatedAt', 'createdBy', 'level', 'ip' ,'createdAt', 'updatedAt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('comments/messages', 'ID'),
            'entity' => Yii::t('comments/messages', 'Entity'),
            'entityId' => Yii::t('comments/messages', 'Entity ID'),
            'content' => Yii::t('comments/messages', 'Content'),
            'parentId' => Yii::t('comments/messages', 'Parent ID'),
            'level' => Yii::t('comments/messages', 'Level'),
            'creatorType' => Yii::t('comments/messages', 'Creator Type'),
            'said_name' => Yii::t('comments/messages', 'Said Name'),
            'said_email' => Yii::t('comments/messages', 'Said Email'),
            'ip' => Yii::t('comments/messages', 'Ip'),
            'createdBy' => Yii::t('comments/messages', 'Created By'),
            'updatedBy' => Yii::t('comments/messages', 'Updated By'),
            'status' => Yii::t('comments/messages', 'Status'),
            'createdAt' => Yii::t('comments/messages', 'Created At'),
            'updatedAt' => Yii::t('comments/messages', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [//Использование поведения TimestampBehavior ActiveRecord
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['createdAt'],
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updatedAt'],

                ],
                'value' => function(){
                                return gmdate("Y-m-d H:i:s");
                },
            //'value' => new \yii\db\Expression('NOW()'),

            ],
            
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'createdBy',
                'updatedByAttribute' => 'updatedBy',
                'defaultValue' => null,
            ],
            
            'purify' => [
                'class' => PurifyBehavior::className(),
                'attributes' => ['content', 'said_name'],
                'config' => function ($config) {
                                $def = $config->getHTMLDefinition(true);
                                $def->addElement('mark', 'Inline', 'Inline', 'Common');
                                $def->addElement('mark', 'Inline', 'Inline', 'Common');
                                $def->addAttribute('a', 'id', 'Text');
                                $def->addAttribute('img', 'class', 'Text');
                                $def->addAttribute('a', 'target', 'Text');
                            }
            ],
                    
            [
                'class' => AttributesBehavior::className(),
                'attributes' => [
                    'creatorType' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => function ($event, $attribute) {
                            if(Yii::$app->user->isGuest){
                                return self::CREATOR_TYPE_GUEST;
                            }else{
                                return self::CREATOR_TYPE_USER;
                            }
                        },
                        ActiveRecord::EVENT_BEFORE_UPDATE => \Yii::$app->formatter->asDatetime('2017-07-13'),
                    ],
                    'status' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => self::STATUS_PUBLIC,
                    ],
                    'ip' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => function ($event, $attribute) {
                            return Yii::$app->request->userIP;
                        }
                    ],
                    'level' => [
                        ActiveRecord::EVENT_AFTER_VALIDATE => function ($event, $attribute) {
                            if(!$this instanceof CommentsSearch){
                                return $this->makeLevel();
                            }
                          
                        }
                            
                            
                    ],
                    'parentId' => [
                        ActiveRecord::EVENT_BEFORE_VALIDATE => function ($event, $attribute) {
                            if(!$this instanceof CommentsSearch){
                                if(empty($this->$attribute)){
                                    return 0;
                                }
                                return $this->$attribute;
                            }
                            
                        }
                    ],       
                            
                ],
            ],
        ];
    }
    
    
    
    public function makeLevel(){
        $level = 1;
        if($this->parentId){
//            var_dump($this->parentId);die();
            $parentComment = static::findOne(['id' => $this->parentId]);
            $level = $parentComment->level + 1;
        }
        
        return $level;
    }
    
    /*
     * If material in page is authored by this comment creator
     */
    public function isMaterialAuthor($materialAuthorId){
        return $materialAuthorId === $this->createdBy;
    }


    public function createdByGuest()
    {
        return $this->creatorType === self::CREATOR_TYPE_GUEST;
    }
    
    public function createdByUser()
    {
        return $this->creatorType === self::CREATOR_TYPE_USER;
    }
    
    /**
     * Author relation
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Module::instance()->userIdentityClass, ['id' => 'createdBy']);
    }
    
    public static function getTree($entity, $entityId, $maxLevel = null)
    {
        $query = static::find()
            ->alias('c')
            ->andWhere([
                'c.entityId' => $entityId,
                'c.entity' => $entity,
            ])
            ->orderBy(['c.parentId' => SORT_ASC, 'c.createdAt' => SORT_ASC])
            ->with(['author']);
        if ($maxLevel > 0) {
            $query->andWhere(['<=', 'c.level', $maxLevel]);
        }
        $models = $query->all();
        if (!empty($models)) {
            $models = static::buildTree($models);
        }
        return $models;
    }
    /**
     * Build comments tree.
     *
     * @param array $data comments list
     * @param int $rootID
     *
     * @return array|ActiveRecord[]
     */
    protected static function buildTree(&$data, $rootID = 0)
    {
        $tree = [];
        foreach ($data as $id => $node) {
            if ($node->parentId == $rootID) {
                unset($data[$id]);
                $node->children = self::buildTree($data, $node->id);
                $tree[] = $node;
            }
        }
        return $tree;
    }
    
    /**
     * @return bool
     */
    public function hasChildren()
    {
        return !empty($this->children);
    }
    
    /**
     * @return array|null|ActiveRecord[]
     */
    public function getChildren()
    {
        return $this->children;
    }
    
    public function getAvatar()
    {
        if($this->createdByUser()){
            if ($this->author->hasMethod('getAvatar')) {
                return $this->author->getAvatar();
            }
        }
        
        return 'http://www.gravatar.com/avatar?d=mm&f=y&s=50';
    }
    
    /**
     * @return mixed
     */
    public function getAuthorName()
    {
        if($this->createdByGuest()){
            return $this->said_name ? $this->said_name : Yii::t('comments/messages', 'Guest');
        }else{
            return $this->author->username;
        }
        
    }
    
    public static function setToggleLike($commentId){
        $commentModel = self::findOne($commentId);
        \Yii::debug('setToggleLike');
        if ($commentModel !== null) {
            $userLike = self::findLikerInComment($commentId);
            $step = 1;
            if($userLike){
                $userLike->delete();
                $step = -1;
            }else{
                $commentsLikesModel =  Yii::createObject([
                    'class' => CommentsLikes::class,
                    'comment_id' => $commentId,
                ]);
                        
                $commentsLikesModel->save();
            }
            
            $commentModel->updateCounters(['like_count' => $step]);
            $commentModel->save();
//            Yii::$app->getView()->registerJs("console.log($commentModel->like_count)");
            return $commentModel->like_count;
        }
        
        return false;

        
    }
    
    public static function findLikerInComment($commentId){
        $ipLiker = Yii::$app->request->userIP;
        $idUser = 0;

        if (!Yii::$app->user->isGuest) {
            $idUser = Yii::$app->user->id;
        }

        $condition = $idUser ? ['comment_id' => $commentId, 'user_id' => $idUser] : ['comment_id' => $commentId, 'ip' => $ipLiker, 'user_id' => $idUser];

        $userLike = CommentsLikes::findOne($condition);
        
        return $userLike;
    }
    
    public static function markAsDesibled($commentId){
        $commentModel = self::findOne($commentId);
        $commentModel->status = self::STATUS_DISABLED;
        return $commentModel->save();
        
    }
    
    public static function markAsActive($commentId){
        $commentModel = self::findOne($commentId);
        $commentModel->status = self::STATUS_PUBLIC;
        return $commentModel->save();
        
    }
    
    public function isSelfLikedComment(){
        return self::findLikerInComment($this->id) ? true : false;
    }

    public function isDesibled(){
        return $this->status === self::STATUS_DISABLED;
    }
    
    public function isActive(){
        return $this->status === self::STATUS_PUBLIC;
    }
    
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentsLikes()
    {
        return $this->hasMany(CommentsLikes::className(), ['comment_id' => 'id']);
    }
    
    public static function hasComments($entity, $entityId)
    {
        return self::find()->where(['entity' => $entity, 'entityId' => $entityId])->scalar();
    }
    
    
    /**
     * {@inheritdoc}
     * @return CommentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommentsQuery(get_called_class());
    }
}
