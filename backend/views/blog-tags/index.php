<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\blog\BlogTagsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/admin', 'Blog Tags');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-tags-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/admin', 'Create').' '.Yii::t('app/admin', 'Blog Tags'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'title',
            'alias',
            'metaTitle',
            'metaDescription',

            [
                'attribute' => 'countArtGrid',
                'format' => 'raw',
                'label' => 'Кол-во статей',
                'value' => function ($model, $key, $index, $column) {
                    $activeArts = $model->getBlogArticles()->active()->count();
                    $disabledArts = $model->getBlogArticles()->disabled()->count();
                    return $model->cntArticles . "<small> активн:{$activeArts}". " откл:{$disabledArts}</small>";
                },
        
            ],
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
