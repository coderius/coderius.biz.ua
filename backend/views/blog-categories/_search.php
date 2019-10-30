<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\blog\BlogCategoriesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-categories-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'metaTitle') ?>

    <?= $form->field($model, 'metaDesc') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/admin', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/admin', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
