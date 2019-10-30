<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\blog\BlogTags */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-tags-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'metaTitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'metaDescription')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'metaKeywords')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/admin', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
