<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = $this->title;

?>

<main class="col-md-9 col-sm-8 col-xs-12 col-xxs-12">
<h1 class="col-xs-12 h_style_1 text_center"><?= $this->title;?></h1>    
<div class="site-login">
    <div class="col-xs-6 col-xs-offset-3 col-xxs-12 col-xxs-offset-0 text-style-1 alert alert-info">
        <p>Пожалуйста, заполните поля для регистрации на сайте:</p>
        <p>Есть учетная запись? <a class="color-japaneseLaurel" href="<?= Url::toRoute(['login']);?>"><strong>Войдите.</strong></a></p>
    </div>

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3 col-xxs-12 col-xxs-offset-0">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => false]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</main>    
