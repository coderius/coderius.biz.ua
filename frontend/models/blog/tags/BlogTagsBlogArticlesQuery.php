<?php

namespace frontend\models\blog\tags;

/**
 * This is the ActiveQuery class for [[BlogTagsBlogArticles]].
 *
 * @see BlogTagsBlogArticles
 */
class BlogTagsBlogArticlesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BlogTagsBlogArticles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BlogTagsBlogArticles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
