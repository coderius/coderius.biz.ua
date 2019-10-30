<?php

namespace common\models\user_social_auth;

/**
 * This is the ActiveQuery class for [[UserSocialAuth]].
 *
 * @see UserSocialAuth
 */
class UserSocialAuthQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserSocialAuth[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserSocialAuth|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
