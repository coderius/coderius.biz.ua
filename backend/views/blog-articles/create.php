<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\blog\BlogArticles */

$this->title = Yii::t('app/admin', 'Create').' '.Yii::t('app/admin', 'Blog Articles');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/admin', 'Blog Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-articles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
