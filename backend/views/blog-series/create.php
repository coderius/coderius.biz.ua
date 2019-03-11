<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\blog\BlogSeries */

$this->title = Yii::t('app/admin', 'Create Blog Series');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/admin', 'Blog Series'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-series-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
