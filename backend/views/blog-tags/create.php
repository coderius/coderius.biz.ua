<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\blog\BlogTags */

$this->title = Yii::t('app/admin', 'Create Blog Tags');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/admin', 'Blog Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-tags-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
