<?php

namespace backend\models\blog;

use Yii;

/**
 * This is the model class for table "blogTags_blogArticles".
 *
 * @property int $id
 * @property int $idBlogTag
 * @property int $idBlogArticle
 *
 * @property BlogArticles $blogArticle
 * @property BlogTags $blogTag
 */
class BlogTagsBlogArticles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blogTags_blogArticles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idBlogTag', 'idBlogArticle'], 'required'],
            [['idBlogTag', 'idBlogArticle'], 'integer'],
            [['idBlogTag', 'idBlogArticle'], 'unique', 'targetAttribute' => ['idBlogTag', 'idBlogArticle']],
            [['idBlogArticle'], 'exist', 'skipOnError' => true, 'targetClass' => BlogArticles::className(), 'targetAttribute' => ['idBlogArticle' => 'id']],
            [['idBlogTag'], 'exist', 'skipOnError' => true, 'targetClass' => BlogTags::className(), 'targetAttribute' => ['idBlogTag' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/admin', 'ID'),
            'idBlogTag' => Yii::t('app/admin', 'Id Blog Tag'),
            'idBlogArticle' => Yii::t('app/admin', 'Id Blog Article'),
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
    public function getBlogTag()
    {
        return $this->hasOne(BlogTags::className(), ['id' => 'idBlogTag']);
    }
}
