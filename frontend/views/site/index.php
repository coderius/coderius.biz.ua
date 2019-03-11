<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\helpers\BaseStringHelper;
use yii\widgets\LinkPager;//для пагинации
use yii\widgets\Breadcrumbs;
use common\components\helpers\CustomStringHelper;
use common\widgets\Alert;
use common\widgets\viewBlocks\bigPics\BigPicsWidget;
use common\widgets\viewBlocks\cellPics\CellPicsWidget;
use common\widgets\viewBlocks\fullColumnPics\FullColumnPicsWidget;
use common\widgets\viewBlocks\middleColumnPics\MiddleColumnPicsWidget;
use common\widgets\viewBlocks\fullLiteColumnPics\FullLiteColumnPicsWidget;
use common\widgets\viewBlocks\bigAndSmallPics\BigAndSmallPicsWidget;

?>


<main class="col-md-12 col-sm-12 col-xs-12 col-xxs-12">

        
<?php if($na = $newArticles->all()): ?>   
    
   
<?= CellPicsWidget::widget([
    
    'model' => $na,
    'header' => [
        
        'name' => 'Свежие записи.',
        'icon-class' => 'fa fa-bookmark-o color-salat'
    ],
//    'section_separator_top' => [
//        'class' => 'border-top-separator row-side-margin',
//    ],
    'button' => [
        'name' => 'Все посты блога ('.$allArticlesCount.') <i class="fa fa-arrow-right" aria-hidden="true"></i>',
        'url' => Url::toRoute(['/blog']),
        'class' => 'btn btn-info pull-right btn-lg btn-custom',
        'icon-class' => 'fa fa-bookmark-o color-salat'
    ],
//    'section_separator_bottom' => [
//        'class' => 'border-top-separator row-side-margin',
//    ],
    
    
    ]); 
?>    
<?php endif; ?>    
 

    
<?php //echo BigPicsWidget::widget([
    
//    'model' => $newArticles->all(),
//    'header' => [
//        
//        'name' => 'Свежие записи.',
//        'icon-class' => 'fa fa-bookmark-o color-salat'
//    ],
//    'section_separator_top' => [
//        'class' => 'border-top-separator row-side-margin',
//    ],
//    'section_separator_bottom' => [
//        'class' => 'border-top-separator row-side-margin',
//    ],
    
    
//    ]); 
?>
    
    
<?php //echo FullColumnPicsWidget::widget([
    
//    'model' => $newArticles->all(),
//    'header' => [
//        
//        'name' => 'Свежие записи.',
//        'icon-class' => 'fa fa-bookmark-o color-salat'
//    ],
//    'section_separator_top' => [
//        'class' => 'border-top-separator row-side-margin',
//    ],
//    'section_separator_bottom' => [
//        'class' => 'border-top-separator row-side-margin',
//    ],
    
    
//    ]); 
?>    
    
<?php //echo MiddleColumnPicsWidget::widget([
    
//    'model' => $newArticles->all(),
//    'header' => [
//        
//        'name' => 'Свежие записи.',
//        'icon-class' => 'fa fa-bookmark-o color-salat'
//    ],
//    'section_separator_top' => [
//        'class' => 'border-top-separator row-side-margin',
//    ],
//    'section_separator_bottom' => [
//        'class' => 'border-top-separator row-side-margin',
//    ],
    
    
//    ]); 
?>      

    
<?php //echo FullLiteColumnPicsWidget::widget([
    
//    'model' => $newArticles->all(),
//    'header' => [
//        
//        'name' => 'Свежие записи.',
//        'icon-class' => 'fa fa-bookmark-o color-salat'
//    ],
//    'section_separator_top' => [
//        'class' => 'border-top-separator row-side-margin',
//    ],
//    'section_separator_bottom' => [
//        'class' => 'border-top-separator row-side-margin',
//    ],
    
    
//    ]); 
?>  
    

<?php //echo BigAndSmallPicsWidget::widget([
    
//    'model' => $newArticles->all(),
//    'header' => [
//        
//        'name' => 'Свежие записи.',
//        'icon-class' => 'fa fa-bookmark-o color-salat'
//    ],
//    'section_separator_top' => [
//        'class' => 'border-top-separator row-side-margin',
//    ],
//    'section_separator_bottom' => [
//        'class' => 'border-top-separator row-side-margin',
//    ],
    
    
//    ]); 
?> 

    


    
    
    
    
    
    
    
    
    
</main>

