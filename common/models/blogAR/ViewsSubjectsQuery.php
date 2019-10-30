<?php

namespace common\models\blogAR;

/**
 * This is the ActiveQuery class for [[ViewsSubjects]].
 *
 * @see ViewsSubjects
 */
class ViewsSubjectsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ViewsSubjects[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ViewsSubjects|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
