<?php

namespace frontend\models\blog\categories;

use Yii;
use frontend\models\blog\EnumBlog;
use frontend\models\blog\articles\BlogArticles;
use yii\helpers\Url;

/**
 * This is the model class for table "blogCategories".
 *
 * @property int $id
 * @property string $alias
 * @property string $metaTitle
 * @property string $metaDesc
 * @property string $title
 * @property int $sort_order
 *
 * @property BlogArticles[] $blogArticles
 */
class BlogCategories extends \yii\db\ActiveRecord
{
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
            [['alias', 'metaTitle', 'metaDesc', 'title'], 'required'],
            [['sort_order'], 'integer'],
            [['alias', 'metaTitle', 'metaDesc', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias'),
            'metaTitle' => Yii::t('app', 'Meta Title'),
            'metaDesc' => Yii::t('app', 'Meta Desc'),
            'title' => Yii::t('app', 'Title'),
            'sort_order' => Yii::t('app', 'Sort Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticles()
    {
        return $this->hasMany(BlogArticles::className(), ['idCategory' => 'id']);
    }
    
    public function getOwnArticles()
    {
            return $this->getBlogArticles()->active()->orderCreatedAt();
    }

    public static function findCategoryByAlias($alias)
    {
        return self::find()->andWhere(['alias' => $alias])->one();
    }
    
    public static function countAllActiveArticlesByCategoryAlias($aliasCategory){
        $res =  self::find()
                ->joinWith([
                    'blogArticles' => function ($query) {
                        $query->active();
                    },
                ])
                ->andWhere([self::tableName().'.alias' => $aliasCategory])            
                ->count();
                    
                    
//                ->joinWith('blogArticles')
//                ->where(['blogArticles.flagActive' => EnumBlog::ARTICLE_STATUS_ACTIVE])
//                ->count();
                
        return $res;
    }
    
    public function getUrl(){
        return Url::toRoute(['/blog/category', 'alias' => $this->alias]);
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
