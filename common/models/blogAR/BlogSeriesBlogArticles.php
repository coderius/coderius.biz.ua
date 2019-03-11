<?php

namespace common\models\blogAR;

use Yii;

/**
 * This is the model class for table "blogSeries_blogArticles".
 *
 * @property int $id
 * @property int $idBlogSery
 * @property int $idBlogArticle
 * @property int $sortNum
 *
 * @property BlogArticles $blogArticle
 * @property BlogSeries $blogSery
 */
class BlogSeriesBlogArticles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blogSeries_blogArticles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idBlogSery', 'idBlogArticle'], 'required'],
            [['idBlogSery', 'idBlogArticle', 'sortNum'], 'integer'],
            [['idBlogSery', 'idBlogArticle'], 'unique', 'targetAttribute' => ['idBlogSery', 'idBlogArticle']],
            [['idBlogArticle'], 'exist', 'skipOnError' => true, 'targetClass' => BlogArticles::className(), 'targetAttribute' => ['idBlogArticle' => 'id']],
            [['idBlogSery'], 'exist', 'skipOnError' => true, 'targetClass' => BlogSeries::className(), 'targetAttribute' => ['idBlogSery' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'idBlogSery' => Yii::t('app', 'Id Blog Sery'),
            'idBlogArticle' => Yii::t('app', 'Id Blog Article'),
            'sortNum' => Yii::t('app', 'Sort Num'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticle()
    {
        return $this->hasOne(BlogArticles::className(), ['id' => 'idBlogArticle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogSery()
    {
        return $this->hasOne(BlogSeries::className(), ['id' => 'idBlogSery']);
    }

    /**
     * @inheritdoc
     * @return BlogSeriesBlogArticlesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogSeriesBlogArticlesQuery(get_called_class());
    }
}
