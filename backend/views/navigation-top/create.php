<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\fragments\NavigationTop */

$this->title = Yii::t('app/admin', 'Create Navigation Top');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/admin', 'Navigation Tops'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="navigation-top-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
