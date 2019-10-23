<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\BaseStringHelper; //для пагинации
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = $this->title;
?>

<main class="col-md-9 col-sm-8 col-xs-12 col-xxs-12">
<h1 class="col-xs-12 h_style_1 text_center"><?=$this->title;?></h1>
<div class="site-login">
    <div class="col-xs-6 col-xs-offset-3 col-xxs-12 col-xxs-offset-0 text-style-1 alert alert-info">
        <p>Пожалуйста, заполните поля для входа на сайт:</p>
        <p>Нет учетной записи? <a class="color-japaneseLaurel" href="<?=Url::toRoute(['signup']);?>"><strong>Зарегестрируйтесь.</strong></a></p>
    </div>



    <div class="row">
        <div class="col-xs-6 col-xs-offset-3 col-xxs-12 col-xxs-offset-0">


        <?= yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['site/auth'],
            'popupMode' => false,
        ]) ?>




            <?php $form = ActiveForm::begin(['id' => 'login-form']);?>

                <?=$form->field($model, 'username')->textInput(['autofocus' => false])?>

                <?=$form->field($model, 'password')->passwordInput()?>
                <div class="g-recaptcha" data-sitekey="6Lf06GQUAAAAAByICvtn0Xx8xyXBKNtstoUrs7yr" data-callback = 'callback' data-expired-callback = 'expiredCallback'></div>
                <?php echo $form->field($model, 'recaptcha', ['template' => '{input}{error}'])->hiddenInput(); ?>

                <?=$form->field($model, 'rememberMe')->checkbox()?>

<!--                <div style="color:#999;margin:1em 0">
                    Если Вы забыли пароль, можете <?=Html::a('обновить пароль', ['site/request-password-reset'])?>.
                </div>-->

                <div class="form-group">
                    <?=Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button'])?>
                </div>

            <?php ActiveForm::end();?>
        </div>

    </div>
</div>
</main>


<?php
$this->registerJsFile("https://www.google.com/recaptcha/api.js", ['async' => true, 'defer' => true]);

$recaptchaId = Html::getInputId($model, 'recaptcha');

$js = <<<JS

var inputRecaptcha = $('#$recaptchaId');
    inputRecaptcha.val('');//page new load
//if checked
function callback(){
    console.log("$recaptchaId");
    inputRecaptcha.val(true);
    inputRecaptcha.trigger("change");
};

function expiredCallback(){
    inputRecaptcha.val('');
    inputRecaptcha.trigger("change");
};

JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>
