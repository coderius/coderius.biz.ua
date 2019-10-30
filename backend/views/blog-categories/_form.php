<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\blog\BlogCategories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // echo $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'metaTitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'metaDesc')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'metaKeywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/admin', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
