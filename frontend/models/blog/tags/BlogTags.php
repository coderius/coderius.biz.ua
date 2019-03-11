<?php

namespace frontend\models\blog\tags;

use Yii;
use frontend\models\blog\EnumBlog;
use frontend\models\blog\articles\BlogArticles;
use yii\helpers\Url;

/**
 * This is the model class for table "blogTags".
 *
 * @property int $id
 * @property string $title
 * @property string $alias
 * @property string $metaTitle
 * @property string $metaDescription
 * @property string $metaKeywords
 * @property BlogTagsBlogArticles[] $blogTagsBlogArticles
 * @property BlogArticles[] $blogArticles
 */
class BlogTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blogTags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias', 'metaTitle', 'metaDescription'], 'required'],
            [['title', 'alias', 'metaTitle', 'metaDescription'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'alias' => Yii::t('app', 'Alias'),
            'metaTitle' => Yii::t('app', 'Meta Title'),
            'metaDescription' => Yii::t('app', 'Meta Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogTagsBlogArticles()
    {
        return $this->hasMany(BlogTagsBlogArticles::className(), ['idBlogTag' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticles()
    {
        return $this->hasMany(BlogArticles::className(), ['id' => 'idBlogArticle'])->viaTable('blogTags_blogArticles', ['idBlogTag' => 'id']);
    }

    public static function countAllActiveArticlesByTagAlias($aliasTag){
        $res =  self::find()
                ->joinWith([
                    'blogArticles' => function ($query) {
                        $query->active();
                    },
                ])
                ->andWhere([self::tableName().'.alias' => $aliasTag])            
                ->count();
                    
                    
//                ->joinWith('blogArticles')
//                ->where(['blogArticles.flagActive' => EnumBlog::ARTICLE_STATUS_ACTIVE])
//                ->count();
             
//        var_dump($res);die;            
                    
        return $res;
    }
    
    public static function findTagByAlias($aliasTag){
        return self::find()->andWhere(['alias' => $aliasTag])->one();
    }

    public function getUrl(){
        return Url::toRoute(['/blog/tag', 'alias' => $this->alias]);
    }
    
    /**
     * @inheritdoc
     * @return BlogTagsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogTagsQuery(get_called_class());
    }
}
