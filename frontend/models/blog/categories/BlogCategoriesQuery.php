<?php

namespace frontend\models\blog\categories;

/**
 * This is the ActiveQuery class for [[BlogCategories]].
 *
 * @see BlogCategories
 */
class BlogCategoriesQuery extends \yii\db\ActiveQuery
{
    public function orderId($sort = SORT_DESC)
    {
        return $this->orderBy(['id' => $sort]);
    }

    /**
     * @inheritdoc
     * @return BlogCategories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BlogCategories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
    public function findAlias($alias)
    {
            return $this->andWhere(['alias' => $alias]);
    }

    
    
}
