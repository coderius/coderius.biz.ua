<?php

namespace modules\comments\models;

use Yii;
use yii\helpers\Url;
use yii\base\Model;
use modules\comments\widgets\commentsBlock\ReCaptcha;
use modules\comments\widgets\commentsBlock\ReCaptchaResponse;
/**
 * ContactForm is the model behind the contact form.
 */
class CommentsForm extends Model
{
    const SCENARIO_USER = 'user';
    const SCENARIO_GUEST = 'guest';
    
    public $entity;
    public $entityId;
    public $said_name;
    public $said_email;
    public $content;
    public $parentId;
    
    public $verifyCode;

    /**
     * @inheritdoc
     * Когда капча не установлена и нажата кнопка submit - сообщение
     * Когда установлена и пройдино, то сообщений нет
     * Когда не пройдино, то сообщение что вы бот.
     */
    public function rules()
    {
        return [
            [['content', 'said_name', 'verifyCode'], 'required'],
            ['verifyCode', 'captcha', 'captchaAction' => Url::toRoute(['/comments/default/captcha'])],
       
            [['said_name', 'said_email'], 'string', 'max' => 255],
            ['said_email', 'email'],
            [['content'], 'string', 'max' => 2000],
//            ['parentId', 'validateParentID'],
        ];
    }
    
 
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_USER] = ['content', 'verifyCode'];
        $scenarios[self::SCENARIO_GUEST] = ['content', 'said_name', 'said_email', 'verifyCode'];
        return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'content' => Yii::t('comments/messages', 'Content'),
            'said_name' => Yii::t('comments/messages', 'Said Name'),
            'said_email' => Yii::t('comments/messages', 'Said Email'),
            
        ];
    }
    
    /**
     * Validate parentId attribute
     * @param $attribute
     */
    public function validateParentID($attribute)
    {
        if ($this->{$attribute} !== null) {
            $comment = Comments::find()->where(['id' => $this->{$attribute}, 'entity' => $this->entity, 'entityId' => $this->entityId])->active()->exists();
            if ($comment === false) {
                $this->addError('message', 'Что-то пошло не так. Повторите еще раз.');
            }
        }
    }
    
//    public function beforeValidate()
//    {
//        if(Yii::$app->user->isGuest){
//            $this->scenario = self::SCENARIO_GUEST;
//        }else{
//            $this->scenario = self::SCENARIO_USER;
//        }
//        
// 
//        return parent::beforeValidate();
//    }
    

}


