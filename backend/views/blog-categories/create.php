<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\blog\BlogCategories */

$this->title = Yii::t('app/admin', 'Create Blog Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/admin', 'Blog Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-categories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
