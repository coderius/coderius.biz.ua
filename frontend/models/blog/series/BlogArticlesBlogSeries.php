<?php

namespace frontend\models\blog\series;

use Yii;

/**
 * This is the model class for table "blogArticles_blogSeries".
 *
 * @property int $id
 * @property int $idArticle
 * @property int $idSery
 *
 * @property BlogArticles $article
 * @property BlogSeries $sery
 */
class BlogArticlesBlogSeries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blogArticles_blogSeries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idArticle', 'idSery'], 'required'],
            [['idArticle', 'idSery'], 'integer'],
            [['idArticle', 'idSery'], 'unique', 'targetAttribute' => ['idArticle', 'idSery']],
            [['idArticle'], 'exist', 'skipOnError' => true, 'targetClass' => BlogArticles::className(), 'targetAttribute' => ['idArticle' => 'id']],
            [['idSery'], 'exist', 'skipOnError' => true, 'targetClass' => BlogSeries::className(), 'targetAttribute' => ['idSery' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'idArticle' => Yii::t('app', 'Id Article'),
            'idSery' => Yii::t('app', 'Id Sery'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(BlogArticles::className(), ['id' => 'idArticle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSery()
    {
        return $this->hasOne(BlogSeries::className(), ['id' => 'idSery']);
    }

    /**
     * @inheritdoc
     * @return BlogArticlesBlogSeriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogArticlesBlogSeriesQuery(get_called_class());
    }
}
