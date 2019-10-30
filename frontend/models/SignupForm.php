<?php
namespace frontend\models;

use yii;
use yii\base\Model;
use common\models\user\User;
use common\components\rbac\Rbac;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\user\User', 'message' => \Yii::t('app/error', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\user\User', 'message' => \Yii::t('app/error', 'This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'username'),
            'password' => Yii::t('app', 'password'),
            'email' => Yii::t('app', 'email'),
        ];
    }
    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->group_user = User::GROUP_USER;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save();
        
        // нужно добавить следующие три строки:
        $auth = Yii::$app->authManager;
        $userRole = $auth->getRole(Rbac::ROLE_USER);
        $auth->assign($userRole, $user->getId());
        
        return $user;
    }
}
