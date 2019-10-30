<?php

namespace common\models\blogAR;

/**
 * This is the ActiveQuery class for [[BlogArticles]].
 *
 * @see BlogArticles
 */
class BlogArticlesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BlogArticles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BlogArticles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
