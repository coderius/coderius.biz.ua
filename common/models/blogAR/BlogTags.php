<?php

namespace common\models\blogAR;

use Yii;

/**
 * This is the model class for table "blogTags".
 *
 * @property int $id
 * @property string $title
 * @property string $alias
 *
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
            [['title', 'alias'], 'required'],
            [['title', 'alias'], 'string', 'max' => 255],
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

    /**
     * @inheritdoc
     * @return BlogTagsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogTagsQuery(get_called_class());
    }
}
