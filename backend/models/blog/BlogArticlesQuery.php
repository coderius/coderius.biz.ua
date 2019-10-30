<?php

namespace backend\models\blog;

/**
 * This is the ActiveQuery class for [[BlogArticles]].
 *
 * @see BlogArticles
 */
class BlogArticlesQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['flagActive' => BlogArticles::ACTIVE_STATUS]);
    }
    
    public function disabled()
    {
        return $this->andWhere(['flagActive' => BlogArticles::DISABLED_STATUS]);
    }
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
