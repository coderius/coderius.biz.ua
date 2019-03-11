<?php

namespace modules\comments\models;

/**
 * This is the ActiveQuery class for [[CommentsLikes]].
 *
 * @see CommentsLikes
 */
class CommentsLikesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CommentsLikes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CommentsLikes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
