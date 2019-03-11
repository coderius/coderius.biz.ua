<?php

use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use common\components\helpers\CustomStringHelper;

//use common\widgets\Alert;
//var_dump($list); die;
?>
 

<?php if ($section_separator_top): ?>
    <div class="<?= $section_separator_top['class']; ?>"></div>
<?php endif; ?>    


<?php if ($header): ?>
    <h2 class="h_style_decoration">
        <i class="<?= $header['icon-class']; ?>" aria-hidden="true"></i>
        <span class="h_style_decoration-text"><?= $header['name']; ?></span>
    </h2>    
<?php endif; ?> 

<div class="row row-side-padding">
<?php foreach ($model as $material): ?>
    <div class="midimgblock col-md-4 col-sm-6 col-xs-6 col-xxs-12">
        <div class="midimgblock-box">
            <div class="midimgblock-linkbox">
                <a class="smallimgblock-link " href="<?= Url::toRoute(['/blog/article', 'alias' => $material->alias]); ?>"></a>
                <div class="img-decorat-light"></div>
                <?php echo Html::img("@img-web-blog-posts/{$material->id}/middle/{$material->faceImg}", ['alt' => $material->title, 'title' => $material->title, 'class' => 'bigimgblock-img']); ?>
            </div> 
            
            <div class="midimgblock-cont">
                <h3 class="h_style_1-2-d midimgblock-header"><a class="link-style-head" href="<?= Url::toRoute(['/blog/article', 'alias' => $material->alias]); ?>"><?= $material->title; ?></a></h3>
            </div>
            
            
            
        </div>   
        
    </div>

<?php endforeach; ?>


</div>

<?php if ($section_separator_bottom): ?>
    <div class="<?= $section_separator_bottom['class']; ?>"></div>
<?php endif; ?>      