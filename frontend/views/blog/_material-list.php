<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
//для пагинации
use common\components\helpers\CustomStringHelper;

//echo \Yii::$app->request->userIP;die;
//phpinfo();
//gmdate("Y-m-d H:i:s")
//Yii::$app->timeZone = 'Europe/Kiev';
?>

<?php foreach ($articles as $article): ?>
    <article class="art_list_prev row">
        <div class="col-md-4 col-xs-12 col-xxs-12">
            <p>
                <a class="art_list_prev-imglink" href="<?= Url::toRoute(['/blog/article', 'alias' => $article->alias]); ?>">
                    <?php
                    echo Html::img(
                            CustomStringHelper::buildSrc(
                                    Yii::$app->params['srcImgArticleBig'], ['id_article' => $article->id,
                                'src' => $article->faceImg,
                                    ]
                            ), ['alt' => $article->faceImgAlt,
                        'title' => $article->title,
                        'class' => 'art_list_prev-imglink-img',
                    ]);
                    ?>
                </a>
            </p>
            <div class="art_list_prev__cont-head">
                <ul class="art_list_prev__cont-head-data">
                    
                    <!--comments-->
                    <?php //if ($article->hasComments()):?>
                    <!-- <li>
                        <i class="fa fa-comment" aria-hidden="true"></i>
                        <span>0</span>
                    </li> -->
                    <?php //endif;?>
                    
                    <!--count views-->
                    <li>
                        <i class="fa fa-eye" aria-hidden="true"></i>
                        <span><?php echo $article->viewCount; ?></span>
                    </li>
                    
                    
                    
                    <?php if ($article->hasTags()): ?>
                        <ul class="art_list_prev__cont-head-tags">
                        <?php foreach ($article->getBlogTags()->all() as $tag): ?>
                                <li><a href="<?= Url::toRoute(['/blog/tag', 'alias' => $tag->alias]); ?>" class="btn btn-default btn-xs"><?= $tag->title; ?></a></li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    
                    <li>
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <span>
                            <?= Yii::$app->formatter->asDatetime($article->createdAt, 'php:l d-F-Y в H:i:s'); ?>
                        </span>
                    </li>
                    
                </ul>

            </div>
            
        </div>    
        <div class="art_list_prev__cont col-md-8 col-xs-12 col-xxs-12">
            
            <h2 class="h_style_3"><a href="<?= Url::toRoute(['/blog/article', 'alias' => $article->alias]); ?>"><?= $article->title; ?></a></h2>
            <div class="art_list_prev__cont__text">
            <?= HtmlPurifier::process(CustomStringHelper::truncate($article->text, 250, $suffix = '...')); ?>

            </div>
            <div class="art_list_prev__cont-footer">
                <ul class="art_list_prev__cont-footer-data">
                    <?php if ($article->hasCategory()): ?>
                    <li>
                        <i class="fa fa-folder" aria-hidden="true"> Категория :</i>
                        <a href="<?= Url::toRoute(['/blog/category', 'alias' => $article->category->alias]); ?>"><span><?= $article->category->title; ?></span></a>
                    </li>
                    <?php endif; ?>
                    
                </ul>
                <?php if ($article->hasSery()): ?>    
                    <ul class="art_list_prev__cont-footer-data art_list_prev-sery">
                        <?php foreach ($article->getSeries()->all() as $sery): ?>
                        <li>
                            <i class="fa fa-book" aria-hidden="true"> Из серии:</i>
                            <a href="<?= Url::toRoute(['/blog/sery', 'alias' => $sery->alias]); ?>"><span><?= $sery->title; ?></span></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

            </div>
        </div>  

    </article>
<?php endforeach; ?>


