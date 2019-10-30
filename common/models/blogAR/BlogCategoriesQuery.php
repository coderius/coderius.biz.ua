<?php

namespace common\models\blogAR;

/**
 * This is the ActiveQuery class for [[BlogCategories]].
 *
 * @see BlogCategories
 */
class BlogCategoriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

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
}
