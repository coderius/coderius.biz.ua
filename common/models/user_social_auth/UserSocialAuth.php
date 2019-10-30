<?php

namespace common\models\user_social_auth;

use Yii;
use common\models\user\User;

/**
 * This is the model class for table "user_social_auth".
 *
 * @property string $id
 * @property string $user_id
 * @property string $source
 * @property string $source_id
 * @property string $nickname
 * @property string $avatar
 * @property string $email
 * @property string $allInfo
 *
 * @property User $user
 */
class UserSocialAuth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_social_auth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'source', 'source_id', 'nickname'], 'required'],
            [['user_id'], 'integer'],
            [['source', 'source_id', 'nickname', 'avatar', 'email'], 'string', 'max' => 255],
            [['allInfo'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('comments/translations', 'ID'),
            'user_id' => Yii::t('comments/translations', 'User ID'),
            'source' => Yii::t('comments/translations', 'Source'),
            'source_id' => Yii::t('comments/translations', 'Source ID'),
            'nickname' => Yii::t('comments/translations', 'Nickname'),
            'avatar' => Yii::t('comments/translations', 'Avatar'),
            'email' => Yii::t('comments/translations', 'Email'),
            'allInfo' => Yii::t('comments/translations', 'All Info'),
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
     * @return UserSocialAuthQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserSocialAuthQuery(get_called_class());
    }
}
