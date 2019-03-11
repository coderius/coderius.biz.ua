<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\blog\BlogCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/admin', 'Blog Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-categories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/admin', 'Create').' '.Yii::t('app/admin', 'Blog Categories'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function ($model, $key, $index, $grid){
            $class = $index % 2 ?'odd':'even';
            return [
                'key'=> $key,
                'index'=> $index,
                'class'=> $class
            ];
        },
        'columns' => [
            [
               'class' => 'yii\grid\SerialColumn',
                    'contentOptions' => ['style' => 'font-size: 100%; color: #d2d2d2;']
            ],
               'id',
               'alias',
               'metaTitle',
               'metaDesc',
               'title',
            
                [
                    'attribute' => 'countArtGrid',
                    'format' => 'raw',
                    'label' => 'Кол-во статей',
                    'value' => function ($model, $key, $index, $column) {
                        $activeArts = $model->getBlogArticles()->active()->count();
                        $disabledArts = $model->getBlogArticles()->disabled()->count();
                        return $model->cntArticles . "<small> активн:{$activeArts}". " откл:{$disabledArts}</small>";
                    },
//                    'filter' => $searchModel->cntArticles,        
                ],
            //'sort_order',

            [
                /**
                 * Указываем класс колонки
                 */
                'class' => \yii\grid\ActionColumn::class,
                /**
                 * Определяем набор кнопочек. По умолчанию {view} {update} {delete}
                 */
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>
</div>
