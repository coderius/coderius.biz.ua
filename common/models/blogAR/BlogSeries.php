<?php

namespace common\models\blogAR;

use Yii;

/**
 * This is the model class for table "blogSeries".
 *
 * @property int $id
 * @property string $alias
 * @property string $metaTitle
 * @property string $metaDesc
 * @property string $title
 * @property int $sortByNum
 *
 * @property BlogSeriesBlogArticles[] $blogSeriesBlogArticles
 * @property BlogArticles[] $blogArticles
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
            [['sortByNum'], 'integer'],
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
            'sortByNum' => Yii::t('app', 'Sort By Num'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogSeriesBlogArticles()
    {
        return $this->hasMany(BlogSeriesBlogArticles::className(), ['idBlogSery' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticles()
    {
        return $this->hasMany(BlogArticles::className(), ['id' => 'idBlogArticle'])->viaTable('blogSeries_blogArticles', ['idBlogSery' => 'id']);
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
