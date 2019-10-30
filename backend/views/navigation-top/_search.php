<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\fragments\NavigationTopSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="navigation-top-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'parentId') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'orderByNum') ?>
    
    <?= $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/admin', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/admin', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
