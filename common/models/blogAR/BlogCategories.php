<?php

namespace common\models\blogAR;

use Yii;

/**
 * This is the model class for table "blogCategories".
 *
 * @property int $id
 * @property string $alias
 * @property string $metaTitle
 * @property string $metaDesc
 * @property string $title
 *
 * @property BlogCategoriesBlogArticles[] $blogCategoriesBlogArticles
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
    public function getBlogCategoriesBlogArticles()
    {
        return $this->hasMany(BlogCategoriesBlogArticles::className(), ['idBlogCategory' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticles()
    {
        return $this->hasMany(BlogArticles::className(), ['id' => 'idBlogArticle'])->viaTable('blogCategories_blogArticles', ['idBlogCategory' => 'id']);
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
