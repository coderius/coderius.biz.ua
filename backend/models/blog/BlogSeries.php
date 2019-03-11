<?php

namespace backend\models\blog;

use Yii;
use yii\behaviors\SluggableBehavior;
/**
 * This is the model class for table "blogSeries".
 *
 * @property int $id
 * @property string $alias
 * @property string $metaTitle
 * @property string $metaDesc
 * @property string $metaKeywords
 * @property string $title
 *
 * @property BlogArticlesBlogSeries[] $blogArticlesBlogSeries
 * @property BlogArticles[] $articles
 */
class BlogSeries extends \yii\db\ActiveRecord
{
    public $cntArticles;
    
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
            [['metaTitle', 'metaDesc', 'title'], 'required'],
            [['metaTitle', 'metaDesc', 'title'], 'string', 'max' => 255],
            [['alias', 'metaKeywords'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/admin', 'ID'),
            'alias' => Yii::t('app/admin', 'Alias'),
            'metaTitle' => Yii::t('app/admin', 'Meta Title'),
            'metaDesc' => Yii::t('app/admin', 'Meta Desc'),
            'metaKeywords' => Yii::t('app/admin', 'Meta Keywords'),
            'title' => Yii::t('app/admin', 'Title'),
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

    /**
     * @inheritdoc
     * @return BlogSeriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogSeriesQuery(get_called_class());
    }
}
