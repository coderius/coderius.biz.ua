<?php

namespace common\models\statistic;

/**
 * This is the ActiveQuery class for [[ViewsStatisticArticles]].
 *
 * @see ViewsStatisticArticles
 */
class ViewsStatisticArticlesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ViewsStatisticArticles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ViewsStatisticArticles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
