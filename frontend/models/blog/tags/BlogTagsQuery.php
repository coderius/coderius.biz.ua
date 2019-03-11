<?php

namespace frontend\models\blog\tags;

/**
 * This is the ActiveQuery class for [[BlogTags]].
 *
 * @see BlogTags
 */
class BlogTagsQuery extends \yii\db\ActiveQuery
{
    public function orderId($sort = SORT_DESC)
    {
        return $this->orderBy(['id' => $sort]);
    }

    /**
     * @inheritdoc
     * @return BlogTags[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BlogTags|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
    
    
}
