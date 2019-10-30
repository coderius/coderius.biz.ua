<?php 

namespace frontend\services\auth;

use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use common\models\user_social_auth\UserSocialAuth;
use common\models\user\User;

class SocialAuthService{

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * If user auth is success
     *
     * @return void
     */
    public function hendlerAuthSuccess()
    {
        $attributes = $this->client->getUserAttributes();
        // var_dump($this->client);die;
        $source = $this->client->getId();
        $sourceId = ArrayHelper::getValue($attributes, 'id');
        $email = ArrayHelper::getValue($attributes, 'email');
        $nickname = ArrayHelper::getValue($attributes, 'name');
        $avatar = $this->extractAvatarUrl($attributes);
        
        //Find social auth accaunt
        $auth = UserSocialAuth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $sourceId,
        ])->one();

        //If is guest
        if (Yii::$app->user->isGuest) {
            //If social accaunt is faund - then log this user in.
            if ($auth) {
                /* @var User $user */
                $user = $auth->user;
                $this->updateUserInfo($user);
                Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
            // signup
            } else {
                //If has email and has user wich this email
                if ($email !== null && User::find()->where(['email' => $email])->exists()) {
                    if($source === 'facebook' || $source === 'google'){
                        //Save social accaunt and login user finded by email
                        //Only for facebook and google
                        $registeredUser = User::find()->where(['email' => $email])->one();
                        $auth = $this->fillSocialAccaunt($registeredUser, $attributes);
                        $auth->save();
                        Yii::$app->user->login($registeredUser, Yii::$app->params['user.rememberMeDuration']);
                    }else{
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->client->getTitle()]),
                        ]);
                    }
                    
                //If has email and also no user related to this email    
                } elseif($email !== null) {
                    $user = $this->fillUserAccaunt($attributes);
                    $transaction = Yii::$app->db->beginTransaction();
                    if ($user->save()) {
                        $auth = $this->fillSocialAccaunt($user, $attributes);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
                        } else {
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app', 'Unable to save {client} account: {errors}', [
                                    'client' => $this->client->getTitle(),
                                    'errors' => json_encode($auth->getErrors()),
                                ]),
                            ]);
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save user: {errors}', [
                                'client' => $this->client->getTitle(),
                                'errors' => json_encode($user->getErrors()),
                            ]),
                        ]);
                    }
                //Has no email in client data    
                }else{
                    Yii::t('app', 'Unable to save {client} account: email required, but not exists', [
                        'client' => $this->client->getTitle(),
                    ]);
                }
            }
        /**  If user */
        }else { 
            // if (!$auth) { // add auth provider
            //     $auth = new Auth([
            //         'user_id' => Yii::$app->user->id,
            //         'source' => $this->client->getId(),
            //         'source_id' => (string)$attributes['id'],
            //     ]);
            //     if ($auth->save()) {
            //         /** @var User $user */
            //         $user = $auth->user;
            //         $this->updateUserInfo($user);
            //         Yii::$app->getSession()->setFlash('success', [
            //             Yii::t('app', 'Linked {client} account.', [
            //                 'client' => $this->client->getTitle()
            //             ]),
            //         ]);
            //     } else {
            //         Yii::$app->getSession()->setFlash('error', [
            //             Yii::t('app', 'Unable to link {client} account: {errors}', [
            //                 'client' => $this->client->getTitle(),
            //                 'errors' => json_encode($auth->getErrors()),
            //             ]),
            //         ]);
            //     }
            // } else { // there's existing auth
            //     Yii::$app->getSession()->setFlash('error', [
            //         Yii::t('app',
            //             'Unable to link {client} account. There is another user using it.',
            //             ['client' => $this->client->getTitle()]),
            //     ]);
            // }

            return;
        }
        
    }

    private function fillSocialAccaunt(User $user, $attributes)
    {
        $source = $this->client->getId();
        $sourceId = ArrayHelper::getValue($attributes, 'id');
        $email = ArrayHelper::getValue($attributes, 'email');
        $nickname = ArrayHelper::getValue($attributes, 'name');
        $avatar = $this->extractAvatarUrl($attributes);
        
        $auth = new UserSocialAuth([
            'user_id' => $user->id,
            'source' => $source,
            'source_id' => (string)$sourceId,
            'nickname' => $nickname,
            'avatar' => $avatar,
            'email' => $email,
            'allInfo' => serialize($attributes),
        ]);

        return $auth;
    }
    
    private function fillUserAccaunt($attributes)
    {
        $source = $this->client->getId();
        $email = ArrayHelper::getValue($attributes, 'email');
        $nickname = ArrayHelper::getValue($attributes, 'name');
        $avatar = $this->extractAvatarUrl($attributes);
        
        $password = Yii::$app->security->generateRandomString(6);
        $user = new User([
            'username' => $nickname,
            'email' => $email,
            'password' => $password,
            'avatar' => $avatar,
            'signup_type' => Yii::$app->params['authType.' . $source],
            'auth_type' => Yii::$app->params['authType.' . $source],
        ]);
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        // var_dump($user);die;
        return $user;
    }

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user)
    {
        $attributes = $this->client->getUserAttributes();
        $source = $this->client->getId();
        //Update auth type, like faceboock or google, if it is changed
        $authType = Yii::$app->params['authType.' . $source];
        if ($user->auth_type !== $authType) {
            $user->auth_type= $authType;
            $user->save();
        }
    }

    private function extractAvatarUrl($attributes)
    {
        $src = '';
        $source = $this->client->getId();
        $avatar = '';

        switch($source){
            case 'facebook':
                $avatar  = ArrayHelper::getValue($attributes, 'picture.data.url');
                break;
        }

        return $avatar;
    
    }

}