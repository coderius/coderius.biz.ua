<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\blog\BlogTags */

$this->title = Yii::t('app/admin', 'Update Blog Tags: {nameAttribute}', [
    'nameAttribute' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/admin', 'Blog Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app/admin', 'Update');
?>
<div class="blog-tags-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
