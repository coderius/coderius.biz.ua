<?php

namespace backend\models\fragments;

use Yii;

/**
 * This is the model class for table "navigationTop".
 *
 * @property int $id
 * @property int $parentId
 * @property string $url
 * @property string $title
 * @property int $orderByNum
 * @property int $status
 */
class NavigationTop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'navigationTop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentId', 'title', 'status'], 'required'],
            [['parentId', 'orderByNum', 'status'], 'integer'],
            [['url', 'title'], 'string', 'max' => 255],
        ];
    }

    public function hasParent(){
        return $this->parentId ? true : false;
    }
    
    public function getParent(){
        return self::findOne($this->parentId);
    }

        /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/admin', 'ID'),
            'parentId' => Yii::t('app/admin', 'Parent ID'),
            'url' => Yii::t('app/admin', 'Url'),
            'title' => Yii::t('app/admin', 'Title'),
            'orderByNum' => Yii::t('app/admin', 'Order By Num'),
            'status' => Yii::t('app/admin', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return NavigationTopQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NavigationTopQuery(get_called_class());
    }
}
