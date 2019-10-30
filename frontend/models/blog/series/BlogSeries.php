<?php

namespace frontend\models\blog\series;

use Yii;
use frontend\models\blog\articles\BlogArticles;
use yii\helpers\Url;

/**
 * This is the model class for table "blogSeries".
 *
 * @property int $id
 * @property string $alias
 * @property string $metaTitle
 * @property string $metaDesc
 * @property string $title
 *
 * @property BlogArticlesBlogSeries[] $blogArticlesBlogSeries
 * @property BlogArticles[] $articles
 */
class BlogSeries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blogSeries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'metaTitle', 'metaDesc', 'title'], 'required'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticlesBlogSeries()
    {
        return $this->hasMany(BlogArticlesBlogSeries::className(), ['idSery' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(BlogArticles::className(), ['id' => 'idArticle'])->viaTable('blogArticles_blogSeries', ['idSery' => 'id']);
    }

    public static function countAllActiveArticlesBySeryAlias($aliasSery){
        $res =  self::find()
                ->joinWith([
                    'articles' => function ($query) {
                        $query->active();
                    },
                ])
                ->andWhere([self::tableName().'.alias' => $aliasSery])            
                ->count();
 
                
        return $res;
    }

    public static function findSeryByAlias($aliasSery){
        return self::find()->andWhere(['alias' => $aliasSery])->one();
    }

    public function getUrl(){
        return Url::toRoute(['/blog/sery', 'alias' => $this->alias]);
    }
    
    /**
     * @inheritdoc
     * @return BlogSeriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogSeriesQuery(get_called_class());
    }
}
