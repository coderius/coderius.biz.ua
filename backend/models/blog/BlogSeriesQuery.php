<?php

namespace backend\models\blog;

/**
 * This is the ActiveQuery class for [[BlogSeries]].
 *
 * @see BlogSeries
 */
class BlogSeriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

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
