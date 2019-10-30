<?php

namespace common\models\blogAR;

use Yii;

/**
 * This is the model class for table "userAccauntSite".
 *
 * @property int $id
 * @property int $idUser
 * @property string $username
 * @property string $avatar
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property Users $user
 */
class UserAccauntSite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userAccauntSite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idUser', 'username', 'auth_key', 'password_hash', 'createdAt'], 'required'],
            [['idUser'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['username', 'avatar', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['idUser'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['idUser'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['idUser' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'idUser' => Yii::t('app', 'Id User'),
            'username' => Yii::t('app', 'Username'),
            'avatar' => Yii::t('app', 'Avatar'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'idUser']);
    }

    /**
     * @inheritdoc
     * @return UserAccauntSiteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserAccauntSiteQuery(get_called_class());
    }
}
