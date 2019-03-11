<?php
namespace modules\comments\components;

use Yii;
use yii\captcha\CaptchaAction;

class MathCaptchaAction extends CaptchaAction
{
    public $minLength = 1;
    public $maxLength = 100;

    /**
     * @inheritdoc
     */
    protected function generateVerifyCode()
    {
        return mt_rand((int)$this->minLength, (int)$this->maxLength);
    }

    /**
     * @inheritdoc
     */
    protected function renderImage($code)
    {
        return parent::renderImage($this->getText($code));
    }

    protected function getText($code)
    {
        $code = (int)$code;
        $rand = mt_rand(min(1, $code - 1), max(1, $code - 1));
        $operation = mt_rand(0, 1);
        if ($operation === 1) {
            return $code - $rand . '+' . $rand;
        } else {
            return $code + $rand . '-' . $rand;
        }
    }
    
    public function validate($input, $caseSensitive)
    {
        $code = $this->getVerifyCode();
        $valid = $caseSensitive ? ($input === $code) : strcasecmp($input, $code) === 0;
        $session = Yii::$app->getSession();
        $session->open();
        $name = $this->getSessionKey() . 'count';
        $session[$name] += 1;
//        Yii::$app->session->set('ses6', $valid);
        if ($session[$name] > $this->testLimit && $this->testLimit > 0) {
            $this->getVerifyCode(true);
            //отправляем сигнал, что нужно обновиться полю капчи
            Yii::$app->session->set('captchaRefresh', true);
        }

        return $valid;
    }
    
    
}

