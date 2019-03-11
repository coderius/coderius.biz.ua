<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\blog\BlogArticles;
use common\components\helpers\CustomStringHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\blog\BlogArticles */
//\Yii::$app->timeZone = 'Europe/Kiev';

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/admin', 'Blog Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//
//\Yii::$app->setTimeZone('Europe/Kiev'); 
//var_dump(new \DateTimeZone('UTC'));

//это работает
//$dt = new DateTime($model->updatedAt, new DateTimeZone('UTC'));
//$dt->setTimezone(new DateTimeZone('Europe/Kiev'));
//$dt->format('Y-m-d H:i:s T');
//var_dump($dt);

?>
<div class="blog-articles-view">
    
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/admin', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/admin', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app/admin', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'idCategory',
            [
                'label' => 'Категория',
                'format' => 'raw',
                'value'  => call_user_func(
                            function ($model){ 
                                $res = [];
                                foreach($model->getCategory()->all() as $category ){
                                    $url = \Yii::$app->urlManagerFrontend->createUrl(["blog/category/{$category->alias}"]);
                                    $res[] = Html::a($category->title, $url, ["class"=>"label label-default", 'target' => '_blank']);
                                }
                                return !empty($res) ? implode(' ', $res) : null;
                                
                            }, $model
                        
                        ),
                
                
            ], 
            
            'alias',
            'metaTitle',
            'metaDesc:ntext',
                                    
//            'title',
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value'  => call_user_func(
                            function ($model){ 
                                $url = \Yii::$app->urlManagerFrontend->createUrl(["blog/article/{$model->alias}"]);
                                return Html::a($model->title, $url, ["class"=>"h3", 'target' => '_blank']);
                            }, $model
                        
                        ),
            ],                       
              
                                    
//            'text:ntext',
            [
                'attribute' => 'text',
                'format' => 'raw',
                'value'  => Html::decode($model->text),
            ],                       
                                    
//            'faceImg',
            [
                'attribute' => 'faceImg',
                'format' => 'raw',
                'value'  => Html::img("@img-web-blog-posts/{$model->id}/thumb/{$model->faceImg}", ['alt'=> $model->faceImgAlt,'title'=> $model->faceImgAlt, 'style'=>'']),
            ],
            
            'faceImgAlt',
            
                        
             [
                'attribute' => 'flagActive',
                'format' => 'raw',
                'value' => call_user_func(
                            function ($model){                      
                                $active = $model->flagActive === BlogArticles::ACTIVE_STATUS;    
                                return Html::tag('span',
                                    BlogArticles::$statusesName[$model->flagActive],
                                    [
                                        'class' => 'label label-' . ($active ? 'success' : 'danger'),
                                    ]
                                );
                            }, $model
                        
                        ) ,
            ],
//            'createdAt',
            
            [
                'attribute' => 'createdAt',
                'format' => 'raw',
                'value'  => CustomStringHelper::localeDataFormat($model->createdAt),
            ],
            [
                'attribute' => 'updatedAt',
                'format' => 'raw',
                'value'  => CustomStringHelper::localeDataFormat($model->updatedAt),
            ],
//            'updatedAt',
//            'createdBy',
            [
                'attribute' => 'createdBy',
                'format' => 'raw',
                'value'  => $model->getCreatedBy()->username(),
            ],                        
                                    

            [
                'attribute' => 'updatedBy',
                'format' => 'raw',
                'value'  => $model->updatedBy ? $model->getUpdatedBy()->username() : null,
            ], 
                                    
            'viewCount',
                                    
            [
                'label' => 'Теги',
                'format' => 'raw',
                'value'  => call_user_func(
                            function ($model){ 
                    
                                $res = [];
                                foreach($model->getBlogTags()->all() as $tag ){
                                    $url = \Yii::$app->urlManagerFrontend->createUrl(["blog/tag/{$tag->alias}"]);
                                    $res[] = Html::a($tag->title, $url, ["class"=>"label label-default", 'target' => '_blank']);
                                }
                                return !empty($res) ? implode(' ', $res) : null;
                    
                            }, $model
                        
                        ),
            ],  
                                    
            [
                'label' => 'Серия',
                'format' => 'raw',
                'value'  => call_user_func(
                            function ($model){ 
                    
                                $res = [];
                                foreach($model->getSeries()->all() as $sery ){
                                    $url = \Yii::$app->urlManagerFrontend->createUrl(["blog/sery/{$sery->alias}"]);
                                    $res[] = Html::a($sery->title, $url,  ["class"=>"label label-primary", 'target' => '_blank']);
                                }
                                return !empty($res) ? implode(' ', $res) : null;
                    
                            }, $model
                        
                        ),
            ],
                                    
        ],
    ]) ?>

</div>
