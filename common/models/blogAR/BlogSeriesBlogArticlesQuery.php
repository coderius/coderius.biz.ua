<?php

namespace common\models\blogAR;

/**
 * This is the ActiveQuery class for [[BlogSeriesBlogArticles]].
 *
 * @see BlogSeriesBlogArticles
 */
class BlogSeriesBlogArticlesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BlogSeriesBlogArticles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BlogSeriesBlogArticles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
