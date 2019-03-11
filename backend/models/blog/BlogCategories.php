<?php

namespace backend\models\blog;

use Yii;
use yii\behaviors\SluggableBehavior;
/**
 * This is the model class for table "blogCategories".
 *
 * @property int $id
 * @property string $alias
 * @property string $metaTitle
 * @property string $metaDesc
 * @property string $metaKeywords
 * @property string $title
 * @property int $sort_order
 *
 * @property BlogArticles[] $blogArticles
 */
class BlogCategories extends \yii\db\ActiveRecord
{
    public $cntArticles;//из таблицы имя алиаса в BlogCategoriesSearch
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blogCategories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['metaTitle', 'metaDesc', 'title'], 'required'],
            [['sort_order'], 'integer'],
            [['metaTitle', 'metaDesc', 'title'], 'string', 'max' => 255],
            [['alias', 'cntArticles', 'metaKeywords'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/admin', 'ID'),
            'alias' => Yii::t('app/admin', 'Alias'),
            'metaTitle' => Yii::t('app/admin', 'Meta Title'),
            'metaDesc' => Yii::t('app/admin', 'Meta Desc'),
            'metaKeywords' => Yii::t('app/admin', 'Meta Keywords'),
            'title' => Yii::t('app/admin', 'Title'),
            'sort_order' => Yii::t('app/admin', 'Sort Order'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'metaTitle',
                 'slugAttribute' => 'alias',
                'immutable' => true,//неизменный
                'ensureUnique'=> true,//генерировать уникальный
                
            ],
            
            
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticles()
    {
        return $this->hasMany(BlogArticles::className(), ['idCategory' => 'id']);
    }

    /**
     * @inheritdoc
     * @return BlogCategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogCategoriesQuery(get_called_class());
    }
}
