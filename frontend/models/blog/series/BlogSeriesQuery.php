<?php

namespace frontend\models\blog\series;

/**
 * This is the ActiveQuery class for [[BlogSeries]].
 *
 * @see BlogSeries
 */
class BlogSeriesQuery extends \yii\db\ActiveQuery
{
    //от новых  к старым
    public function orderId($sort = SORT_DESC)
    {
        return $this->orderBy(['id' => $sort]);
    }
    
    
    /**
     * @inheritdoc
     * @return BlogSeries[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BlogSeries|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
