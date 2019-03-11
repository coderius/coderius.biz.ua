<?php

namespace frontend\models\blog\articles;

use frontend\models\blog\EnumBlog;
use yii\db\Expression;
/**
 * This is the ActiveQuery class for [[BlogArticles]].
 *
 * @see BlogArticles
 */
class BlogArticlesQuery extends \yii\db\ActiveQuery
{
    
    public function active()
    {
        return $this->andWhere([BlogArticles::tableName().'.flagActive' => EnumBlog::ARTICLE_STATUS_ACTIVE]);
    }

    public function category($id)
    {
        return $this->andWhere([BlogArticles::tableName().'.idCategory' => $id]);
    }
    
    //от новых  к старым
    public function orderCreatedAt($sort = SORT_DESC)
    {
        return $this->orderBy(['createdAt' => $sort]);
    }
    
    public function orderUpdatedAt($sort = SORT_DESC)
    {
        return $this->orderBy(['updatedAt' => $sort]);
    }
    
    public function orderViewCount($sort = SORT_DESC)
    {
        return $this->orderBy(['viewCount' => $sort]);
    }
    
    public function orderRandom()
    {
        return $this->orderBy(new Expression('rand()'));
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
    
    public function startNewAreticles()
    {
        return $this->orderBy([BlogArticles::tableName().'.createdAt' => SORT_DESC]);
    }
}
