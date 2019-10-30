<?php

namespace modules\comments\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributesBehavior;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "comments_likes".
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip
 * @property int $comment_id
 * @property string $createdAt
 *
 * @property Comments $comment
 */
class CommentsLikes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments_likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_id'], 'integer'],
            [['comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::className(), 'targetAttribute' => ['comment_id' => 'id']],
            [['ip', 'user_id', 'createdAt'], 'safe'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('comments/messages', 'ID'),
            'user_id' => Yii::t('comments/messages', 'User ID'),
            'ip' => Yii::t('comments/messages', 'Ip'),
            'comment_id' => Yii::t('comments/messages', 'Comment ID'),
            'createdAt' => Yii::t('comments/messages', 'Created At'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [//Использование поведения TimestampBehavior ActiveRecord
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['createdAt'],
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_UPDATE => false,

                ],
                'value' => function(){
                                return gmdate("Y-m-d H:i:s");
                },
            //'value' => new \yii\db\Expression('NOW()'),

            ],
            
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
                'defaultValue' => 0,
            ],
            
            [
                'class' => AttributesBehavior::className(),
                'attributes' => [
                    'ip' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => function ($event, $attribute) {
                            return Yii::$app->request->userIP;
                        }
                    ],
                          
                            
                ],
            ],
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comments::className(), ['id' => 'comment_id']);
    }

    /**
     * {@inheritdoc}
     * @return CommentsLikesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommentsLikesQuery(get_called_class());
    }
}
