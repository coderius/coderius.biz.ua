<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\blog\BlogArticlesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-articles-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idCategory') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'metaTitle') ?>

    <?= $form->field($model, 'metaDesc') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'faceImg') ?>

    <?php // echo $form->field($model, 'faceImgAlt') ?>

    <?php // echo $form->field($model, 'flagActive') ?>

    <?php // echo $form->field($model, 'createdAt') ?>

    <?php // echo $form->field($model, 'updatedAt') ?>

    <?php // echo $form->field($model, 'createdBy') ?>

    <?php // echo $form->field($model, 'updatedBy') ?>

    <?php // echo $form->field($model, 'viewCount') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/admin', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/admin', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
