<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\fragments\NavigationTop;
use common\enum\NavigationTopEnum;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\fragments\NavigationTopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/admin', 'Navigation Tops');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="navigation-top-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/admin', 'Create Navigation Top'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'font-size: 100%; color: #d2d2d2;']
            ],

            'id',
//            'parentId',
            [
                'attribute' => 'parentTitleGrid',
                'label' => 'Родительский пункт',
                'format' => 'raw',
                'filter' => ArrayHelper::map(NavigationTop::find()->all(), 'id', 'title'),
                'value' => function ($model, $key, $index, $column){
                    return $model->hasParent() ? $model->parent->title : null;
                },
            ],
            
            'url:url',
            'title',
            'orderByNum',
//            'status',
            [
                'attribute' => 'status',
//                'label' => 'Родительский пункт',
                'format' => 'raw',
                'filter' => NavigationTopEnum::$statusesName,
                'value' => function ($model, $key, $index, $column){
                    return NavigationTopEnum::$statusesName[$model->status];
                },
            ],            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
