<?php

namespace common\models\likes;

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
    const ACTION_LIKE = 1;
    const ACTION_DISLIKE = 2;
    
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
            [['subject', 'subject_id', 'user_id', 'action'], 'required'],
            [['subject', 'subject_id', 'user_id'], 'integer'],
            [['action'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/admin', 'ID'),
            'subject' => Yii::t('app/admin', 'Subject'),
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

    /**
     * {@inheritdoc}
     * @return LikesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LikesQuery(get_called_class());
    }
}
