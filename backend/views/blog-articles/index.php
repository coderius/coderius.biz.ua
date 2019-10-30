<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use backend\models\blog\BlogArticles;
use backend\models\blog\BlogSeries;
use common\components\helpers\CustomStringHelper;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Alert;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\blog\BlogArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/admin', 'Blog Articles');
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'header' => '<h2>'.\Yii::t('yii', 'Page info').'</h2>',
//    'toggleButton' => ['label' => 'click me'],
    'options' => ['id' => 'myModal'],
    'size' => Modal::SIZE_LARGE,
]);

echo \Yii::t('yii', 'Load...');

Modal::end();

//$js = "$('#myModal').modal('show');";

//$this->registerJs($js, \yii\web\View::POS_READY, "keymyModal");

?>
<div class="blog-articles-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/admin', 'Create').' '.Yii::t('app/admin', 'Blog Articles'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=> function ($model, $key, $index, $grid){
            $class = $index % 2 ?'odd':'even';
            return [
                'key'=> $key,
                'index'=> $index,
                'class'=> $class
            ];
        },
                
        'columns' => [
        [
            'class' => 'yii\grid\CheckboxColumn', 
//            'checkboxOptions' => function($model) {
//                return ['value' => $model->Your_unique_id];
//            },
        ],    
            
        [
            'class' => 'yii\grid\SerialColumn',
            'contentOptions' => ['style' => 'font-size: 100%; color: #d2d2d2;']
        ],
        'id',
//            'idCategory',
//            'alias',
            
            [
                'attribute' => 'metaTitle',
                'format' => 'raw',
                'value' => function ($model) {                      
                        return "<a target='_blank' href=".\Yii::$app->urlManagerFrontend->createUrl(["/blog/article/{$model->alias}"]).">".$model->metaTitle."</a>";
                },
            ],
            
//            'metaDesc:ntext',
            //'title',
            //'text:ntext',
            
            
            //echo Html::img("@img-web-blog-posts/{$material->id}/middle/{$material->faceImg}", ['alt'=> $material->title,'title'=> $material->title, 'class'=>'bigimgblock-img']);
            
            [
                'attribute' => 'faceImg',
                'format' => 'raw',
                'value' => function ($model) {                      
                        return Html::img("@img-web-blog-posts/{$model->id}/middle/{$model->faceImg}", ['alt'=> $model->title,'title'=> $model->title, 'style'=>'width: 100px;']);
                },
            ],
            
            //'faceImgAlt',
//            'flagActive',
            [
                'attribute' => 'flagActive',
                'format' => 'raw',
                'filter' => [
                    BlogArticles::DISABLED_STATUS => BlogArticles::$statusesName[BlogArticles::DISABLED_STATUS],
                    BlogArticles::ACTIVE_STATUS =>  BlogArticles::$statusesName[BlogArticles::ACTIVE_STATUS],
                ],
                'value' => function ($model, $key, $index, $column) {                      
                    $active = $model->{$column->attribute} === BlogArticles::ACTIVE_STATUS;    
                    return Html::tag('span',
                        $active ? 
                            BlogArticles::$statusesName[BlogArticles::ACTIVE_STATUS] 
                            : 
                            BlogArticles::$statusesName[BlogArticles::DISABLED_STATUS],
                        [
                            'class' => 'label label-' . ($active ? 'success' : 'danger'),
                        ]
                    );
                },
            ],      
                        
                        
            [
                'attribute' => 'category',
                'label' => 'Категория',
                'value' => 'category.title',
            ],
        
            [
                'attribute' => 'seriesArtGrid',
                'label' => 'Из серии',
                'format' => 'raw',
                //формируем выпадающий список всех серий. И ключ и значение  title т.к.
                // поиск like производится по строке с именами тегов, созданной из запроса 
                'filter' => ArrayHelper::map(BlogSeries::find()->all(), 'title', 'title'),
                'value' => function ($model, $key, $index, $column){
                    $res = [];
                    foreach($model->getSeries()->all() as $sery ){
                        $url = \Yii::$app->urlManagerFrontend->createUrl(["blog/sery/{$sery->alias}"]);
                        $res[] = Html::a($sery->title, $url,  ["class"=>"label label-primary", 'target' => '_blank']);
                    }
                    return !empty($res) ? implode('<br>', $res) : null;
                },
            ],
                        
            [
                'attribute' => 'tagsArtGrid',
                'label' => 'Теги',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column){
                    $res = [];
                    foreach($model->getBlogTags()->all() as $tag ){
                        $url = \Yii::$app->urlManagerFrontend->createUrl(["blog/tag/{$tag->alias}"]);
                        $res[] = Html::a($tag->title, $url, ["class"=>"label label-default", 'target' => '_blank']);
                    }
                    return !empty($res) ? implode('<br>', $res) : null;
                },
            ],            
                        
            [
                'contentOptions' => ['title' => 'Дата создания', 'style' => 'font-size: 12px'],
                'attribute' => 'createdAt',
                'format' => ['datetime', 'php:d F (D.) Yг. в Hч.iм.'],
            ],            
              
            [
                'contentOptions' => ['title' => 'Дата создания', 'style' => 'font-size: 12px'],
                'attribute' => 'updatedAt',
                'format' => ['datetime', 'php:d F (D.) Yг. в Hч.iм.'],
            ],             
                        
//            'updatedAt',
            //'createdBy',
            //'updatedBy',
            'viewCount',

            [
                /**
                 * Указываем класс колонки
                 */
                'class' => \yii\grid\ActionColumn::class,
                /**
                 * Определяем набор кнопочек. По умолчанию {view} {update} {delete}
                 */
                'template' => '{view} {update} {delete} {info}',
//                'visibleButtons' => ['info' => true],
                'buttons' => [
                    'info' => function ($url, $model, $key) {
                        $iconName = "info-sign";
                        $title = \Yii::t('yii', 'Info');
                        $id = 'info-'.$key;
                        $options = [
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                            'id' => $id
                        ];
                        $url = Url::to(['ajax-view-info-index', 'id' => $key]);
                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                        $csrf_param = Yii::$app->request->csrfParam; 
                        $csrf_token = Yii::$app->request->csrfToken;
                        $js = <<<JS
                        $("#{$id}").on("click",function(event){  
                                event.preventDefault();
                                var myModal = $("#myModal");
                                var modalBody = myModal.find('.modal-body');
                                var modalTitle = myModal.find('.modal-header');
                                
                        
                                $.ajax({
                                        'type' : 'POST',
                                        'url' : '$url',
                                        'dataType' : 'json',
                                        'data' : {
                                                '$csrf_param' : '$csrf_token',
                                                'id' : $key
                                        },
                                        'success' : function(data){
                                                console.log(data.body);
                                                modalTitle.find('h2').html(data.title);
                                                modalBody.html(data.body);
                                        },
                                        'error' : function(request, status, error){
                                                console.log(status);
                                                console.log(error);
                                        }
                                });
                        
                        
                                myModal.modal("show");
                            }
                        );
JS;
                        

                        
                        $this->registerJs($js, \yii\web\View::POS_READY, $id);
                        
//                        var_dump(Url::to(['ajax-view-info-index', 'id' => $key]));
                        
                        return Html::a($icon, $url, $options);
                    },
                ],
            ],
        ],
    ]); ?>
</div>


<?php 
$js = <<<JS
        console.log($('#w0').yiiGridView('getSelectedRows'));
JS;
    
$this->registerJs($js, \yii\web\View::POS_READY);
?>