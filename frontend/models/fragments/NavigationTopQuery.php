<?php

namespace frontend\models\fragments;

/**
 * This is the ActiveQuery class for [[NavigationTop]].
 *
 * @see NavigationTop
 */
class NavigationTopQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return NavigationTop[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NavigationTop|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
    public function noParent()
    {
        return $this->andWhere(['parentId' => 0]);
    }
    
}
