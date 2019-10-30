<?php

namespace common\models\blogAR;

use Yii;

/**
 * This is the model class for table "blogArticles".
 *
 * @property int $id
 * @property int $idCategory
 * @property string $alias
 * @property string $metaTitle
 * @property string $metaDesc
 * @property string $title
 * @property string $text
 * @property string $faceImg
 * @property string $faceImgAlt
 * @property int $flagActive
 * @property string $createdAt
 * @property string $updatedAt
 * @property int $createdBy
 * @property int $updatedBy
 *
 * @property BlogCategories $category
 * @property BlogSeriesBlogArticles[] $blogSeriesBlogArticles
 * @property BlogSeries[] $blogSeries
 * @property BlogTagsBlogArticles[] $blogTagsBlogArticles
 * @property BlogTags[] $blogTags
 */
class BlogArticles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blogArticles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCategory', 'alias', 'metaTitle', 'metaDesc', 'title', 'text', 'faceImg', 'faceImgAlt', 'createdBy', 'updatedBy'], 'required'],
            [['idCategory', 'flagActive', 'createdBy', 'updatedBy'], 'integer'],
            [['metaDesc', 'text'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['alias', 'metaTitle', 'title', 'faceImg', 'faceImgAlt'], 'string', 'max' => 255],
            [['idCategory'], 'exist', 'skipOnError' => true, 'targetClass' => BlogCategories::className(), 'targetAttribute' => ['idCategory' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'idCategory' => Yii::t('app', 'Id Category'),
            'alias' => Yii::t('app', 'Alias'),
            'metaTitle' => Yii::t('app', 'Meta Title'),
            'metaDesc' => Yii::t('app', 'Meta Desc'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'faceImg' => Yii::t('app', 'Face Img'),
            'faceImgAlt' => Yii::t('app', 'Face Img Alt'),
            'flagActive' => Yii::t('app', 'Flag Active'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'createdBy' => Yii::t('app', 'Created By'),
            'updatedBy' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(BlogCategories::className(), ['id' => 'idCategory']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogSeriesBlogArticles()
    {
        return $this->hasMany(BlogSeriesBlogArticles::className(), ['idBlogArticle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogSeries()
    {
        return $this->hasMany(BlogSeries::className(), ['id' => 'idBlogSery'])->viaTable('blogSeries_blogArticles', ['idBlogArticle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogTagsBlogArticles()
    {
        return $this->hasMany(BlogTagsBlogArticles::className(), ['idBlogArticle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogTags()
    {
        return $this->hasMany(BlogTags::className(), ['id' => 'idBlogTag'])->viaTable('blogTags_blogArticles', ['idBlogArticle' => 'id']);
    }

    /**
     * @inheritdoc
     * @return BlogArticlesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogArticlesQuery(get_called_class());
    }
}
