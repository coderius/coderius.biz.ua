<?php

namespace modules\likes\models;

use Yii;
use common\models\user\User;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "likes".
 *
 * @property int $id
 * @property int $subject
 * @property int $subject_id
 * @property int $user_id
 * @property string $action
 * @property User $user
 */
class Likes extends \yii\db\ActiveRecord
{
    const ACTION_LIKE = 'like';
    const ACTION_DISLIKE = 'dislike';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_name', 'subject_id', 'action'], 'required'],
            [['subject_id'], 'integer'],
            [['subject_name', 'action'], 'string'],
//            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['user_id', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/admin', 'ID'),
            'subject_name' => Yii::t('app/admin', 'Subject Name'),
            'subject_id' => Yii::t('app/admin', 'Subject ID'),
            'user_id' => Yii::t('app/admin', 'User ID'),
            'action' => Yii::t('app/admin', 'Action'),
        ];
    }

        public function behaviors()
    {
        return [
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
        ];
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getLikes($subj_name, $subj_material_id){
        
        return self::find()
                ->where(['subject_name' => $subj_name])
                ->andWhere(['subject_id' => $subj_material_id, 'action' => self::ACTION_LIKE])
                ->count('id');
    }
    
    public static function getDislikes($subj_name, $subj_material_id){
        return self::find()
                ->where(['subject_name' => $subj_name])
                ->andWhere(['subject_id' => $subj_material_id, 'action' => self::ACTION_DISLIKE])
                ->count('id');
        
    }
    
    public function hasLike(){
        if(\Yii::$app->user->isGuest){
            return false;
        }
        
        return (boolean) self::find()
                ->where(['subject_name' => $this->subject_name])
                ->andWhere([
                            'subject_id' => $this->subject_id,
                            'action' => self::ACTION_LIKE,
                            'user_id' => \Yii::$app->user->id
                        ])
                ->scalar();
    }
    
    public function hasDislike(){
        if(\Yii::$app->user->isGuest){
            return false;
        }
        
        $res = (boolean) self::find()
                ->where(['subject_name' => $this->subject_name])
                ->andWhere([
                            'subject_id' => $this->subject_id,
                            'action' => self::ACTION_DISLIKE,
                            'user_id' => \Yii::$app->user->id
                        ])
                ->scalar();
        
        
        return $res;
    }
    
    public function setLikes(){
        $model = self::find()
                ->where(['subject_name' => $this->subject_name])
                ->andWhere([
                            'subject_id' => $this->subject_id,
                            'action' => self::ACTION_DISLIKE,
                            'user_id' => \Yii::$app->user->id
                        ])->one();
        
        if ($model !== null) {
            $model->action = self::ACTION_LIKE;
            $model->save();
        }else{
            $this->action = self::ACTION_LIKE;
            $this->save();
        }
        
        return true;
    }
    
    public function setDislikes(){
        $model = self::find()
                ->where(['subject_name' => $this->subject_name])
                ->andWhere([
                            'subject_id' => $this->subject_id,
                            'action' => self::ACTION_LIKE,
                            'user_id' => \Yii::$app->user->id
                        ])->one();
        
        if ($model !== null) {
            $model->action = self::ACTION_DISLIKE;
            $model->save();
        }else{
            $this->action = self::ACTION_DISLIKE;
            $this->save();
        }
        
        return true;
        
    }
    
    public function unsetLikes(){
        self::deleteAll([
                            'subject_name' => $this->subject_name,
                            'subject_id' => $this->subject_id,
                            'action' => self::ACTION_LIKE,
                            'user_id' => \Yii::$app->user->id
                        ]);
    }
    
    public function unsetDislikes(){
        self::deleteAll([
                            'subject_name' => $this->subject_name,
                            'subject_id' => $this->subject_id,
                            'action' => self::ACTION_DISLIKE,
                            'user_id' => \Yii::$app->user->id
                        ]);
    }
    
    /**
     * {@inheritdoc}
     * @return LikesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LikesQuery(get_called_class());
    }
}
