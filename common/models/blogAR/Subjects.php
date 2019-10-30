<?php

namespace common\models\blogAR;

use Yii;

/**
 * This is the model class for table "subjects".
 *
 * @property int $id
 * @property string $tableNameWichId
 * @property string $title
 *
 * @property Views[] $views
 */
class Subjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subjects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tableNameWichId', 'title'], 'required'],
            [['tableNameWichId', 'title'], 'string', 'max' => 255],
            [['tableNameWichId'], 'unique'],
            [['title'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tableNameWichId' => Yii::t('app', 'Table Name Wich ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getViews()
    {
        return $this->hasMany(Views::className(), ['subjectId' => 'id']);
    }

    /**
     * @inheritdoc
     * @return SubjectsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubjectsQuery(get_called_class());
    }
}
