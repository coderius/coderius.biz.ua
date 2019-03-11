<?php

namespace common\models\blogAR;

use Yii;

/**
 * This is the model class for table "viewsSubjects".
 *
 * @property int $id
 * @property int $count
 * @property int $subjectId
 * @property int $itemId
 * @property int $idUser
 *
 * @property Subjects $subject
 * @property Users $user
 */
class ViewsSubjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'viewsSubjects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count', 'subjectId', 'itemId'], 'required'],
            [['count', 'subjectId', 'itemId', 'idUser'], 'integer'],
            [['subjectId'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::className(), 'targetAttribute' => ['subjectId' => 'id']],
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
            'count' => Yii::t('app', 'Count'),
            'subjectId' => Yii::t('app', 'Subject ID'),
            'itemId' => Yii::t('app', 'Item ID'),
            'idUser' => Yii::t('app', 'Id User'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subjects::className(), ['id' => 'subjectId']);
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
     * @return ViewsSubjectsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ViewsSubjectsQuery(get_called_class());
    }
}
