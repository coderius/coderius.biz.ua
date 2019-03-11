<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\user\User;

use common\components\recaptcha\ReCaptcha;
use common\components\recaptcha\ReCaptchaResponse;
/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    public $recaptcha;
    
    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            
            [['username', 'password', 'recaptcha'], 'required'],
            [['recaptcha'], 'recaptchaValidation'],
            
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }
    
    public function recaptchaValidation($attribute, $params) {

        $this->$attribute = $this->recaptcha();
//        var_dump($this->$attribute);die;
        if(true !== $this->$attribute){
            $this->addError($attribute, 'Вы не прошли проверку. Попробуйте еще раз.');
        }
        
    }
    
    protected function recaptcha(){
        //секретный ключ
        $secret = "6Lf06GQUAAAAAG4r4bkkQMhowDNZLOv_BCtxemRM";
        //ответ
        $response = null;
        //проверка секретного ключа
        $reCaptcha = new ReCaptcha($secret);
        //var_dump($_POST);
        if (!empty($_POST)) {

            if ($_POST["g-recaptcha-response"]) {
                $response = $reCaptcha->verifyResponse(
                    $_SERVER["REMOTE_ADDR"],
                    $_POST["g-recaptcha-response"]
                );
                
            }

            if ($response != null && $response->success) {
                return true;
            } else {
                return false;
            }

        }
        
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'username'),
            'password' => Yii::t('app', 'password'),
            'rememberMe' => Yii::t('app', 'rememberMe'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, \Yii::t('app/error', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
