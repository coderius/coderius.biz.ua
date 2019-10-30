<?php

namespace common\models\blogAR;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property int $role
 * @property int $isActive
 * @property string $typeLastLogin
 *
 * @property AccauntSite $accauntSite
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'typeLastLogin'], 'required'],
            [['role', 'isActive'], 'integer'],
            [['typeLastLogin'], 'string'],
            [['email'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'role' => Yii::t('app', 'Role'),
            'isActive' => Yii::t('app', 'Is Active'),
            'typeLastLogin' => Yii::t('app', 'Type Last Login'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccauntSite()
    {
        return $this->hasOne(AccauntSite::className(), ['idUser' => 'id']);
    }

    /**
     * @inheritdoc
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
