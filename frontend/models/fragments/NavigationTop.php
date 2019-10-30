<?php

namespace frontend\models\fragments;

use Yii;
use common\enum\NavigationTopEnum;
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
    private $_children;
    public static $level;

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
            [['parentId', 'title'], 'required'],
            [['parentId', 'orderByNum'], 'integer'],
            [['url', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parentId' => Yii::t('app', 'Parent ID'),
            'url' => Yii::t('app', 'Url'),
            'title' => Yii::t('app', 'Title'),
            'orderByNum' => Yii::t('app', 'Order By Num'),
        ];
    }
    
    public function isActive(){
        return $this->status === NavigationTopEnum::STATUS_ACTIVE;
    }

        protected static function buildTree(&$data, $rootID = 0, $maxLevel = 2)
    {
        if(self::$level <= $maxLevel){
            self::$level++;
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
        
        return false;
        
    }

    public static function getTree()
    {
        $query = self::find();

        $models = $query->orderBy(['parentId' => SORT_ASC])->all();

        if (!empty($models)) {
            $models = self::buildTree($models);
        }
        return $models;
    }
    
    public function getChildren()
    {
        return $this->_children;
    }
    /**
     * $_children setter.
     *
     * @param array|ActiveRecord[] $value Comment children
     */
    public function setChildren($value)
    {
        $this->_children = $value;
    }

    /**
     * Check if comment has children comment
     * @return bool
     */
    public function hasChildren()
    {
        return !empty($this->_children) ? true : false;
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
