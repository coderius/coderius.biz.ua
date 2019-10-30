<?php

namespace backend\models\blog;

use Yii;
use yii\behaviors\SluggableBehavior;
/**
 * This is the model class for table "blogTags".
 *
 * @property int $id
 * @property string $title
 * @property string $alias
 * @property string $metaTitle
 * @property string $metaDescription
 * @property string $metaKeywords
 *
 * @property BlogTagsBlogArticles[] $blogTagsBlogArticles
 * @property BlogArticles[] $blogArticles
 */
class BlogTags extends \yii\db\ActiveRecord
{
    public $cntArticles;
    
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
            [['title','metaTitle', 'metaDescription'], 'required'],
            [['title', 'metaTitle', 'metaDescription'], 'string', 'max' => 255],
            [['metaKeywords', 'alias'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/admin', 'ID'),
            'title' => Yii::t('app/admin', 'Title'),
            'alias' => Yii::t('app/admin', 'Alias'),
            'metaTitle' => Yii::t('app/admin', 'Meta Title'),
            'metaDescription' => Yii::t('app/admin', 'Meta Description'),
            'metaKeywords' => Yii::t('app/admin', 'Meta Keywords'),
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
                'ensureUnique'=>true,//генерировать уникальный
                
            ],
            
            
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
