<?php

namespace frontend\models\blog\series;

/**
 * This is the ActiveQuery class for [[BlogArticlesBlogSeries]].
 *
 * @see BlogArticlesBlogSeries
 */
class BlogArticlesBlogSeriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BlogArticlesBlogSeries[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BlogArticlesBlogSeries|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
