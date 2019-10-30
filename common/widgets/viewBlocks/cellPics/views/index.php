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


<div class="row row-side-padding bg-salat-light">

    <?php $i = 0; ?>
    <?php foreach($model as $material): ?>
    
        <div class="art_list_prev col-md-6 col-sm-12 col-xs-12 col-xxs-12">
            <div class="row">
                <h2 class="h_style_2"><a href="<?= Url::toRoute(['/blog/article', 'alias' => $material->alias]); ?>"><?= $material->title; ?></a></h2>
                <div class="col-xs-4 col-xxs-12">
                    <a class="art_list_prev-imglink" href="<?= Url::toRoute(['/blog/article', 'alias' => $material->alias]); ?>">
                        <?php echo Html::img("@img-web-blog-posts/{$material->id}/middle/{$material->faceImg}", ['alt'=> $material->title,'title'=> $material->title, 'class'=>'bigimgblock-img']);?>
                    </a>
                    <div class="art_list_prev__cont-left">
                        <ul class="art_list_prev__cont-left-data">
                            <li>
                                <i class="fa fa-comment" aria-hidden="true"></i>
                                <span>0</span>
                            </li>
                            <li>
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                <span><?= $material->viewCount; ?></span>
                            </li>
                        </ul>

                            <?php if ($material->hasTags()): ?>
                                <ul class="art_list_prev__cont-left-tags">
                                    <?php foreach ($material->getBlogTags()->limit(3)->all() as $tag): ?>
                                        <li>
                                            <a href="<?= Url::toRoute(['/blog/tag', 'alias' => $tag->alias]); ?>" class="btn btn-default btn-xs"><?= $tag->title; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        
                    </div>
                </div>    
                <div class="art_list_prev__cont col-xs-8 col-xxs-12">
                    <small class="color_text_light">
                        <?= Yii::$app->formatter->asDatetime($material->createdAt, 'php:d-F-Y в H:i:s');?>
                    </small>
                    
                    <div class="art_list_prev__cont__text">
                        <?= HtmlPurifier::process( CustomStringHelper::truncate($material->text, 150, $suffix = '...', false) ); ?>
                    </div>
                </div>

            </div>    
            <!--<div class="border col-xs-12"></div>-->    
        </div>
    
        <?php $i += 1; ?>
        <?php if($i % 2 == 0): ?>
        <div class="clearfix"></div>  
        <?php endif; ?>
    
    <?php endforeach; ?>

    <?php if($button): ?>
    <div class="col-xs-12 col-xxs-12 btn-box">
        <a class="<?= $button['class']; ?>" href="<?= $button['url']; ?>" role="button"><?= $button['name']; ?></a>
    </div>
    <?php endif; ?>

</div><!--новые статьи из блога--> 
<?php if($section_separator_bottom): ?>
<div class="<?= $section_separator_bottom['class']; ?>"></div>
<?php endif; ?> 