<?php

namespace common\models\blogAR;

/**
 * This is the ActiveQuery class for [[Subjects]].
 *
 * @see Subjects
 */
class SubjectsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Subjects[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Subjects|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
