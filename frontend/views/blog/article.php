<?php

/**
 * @file article.php created 06.02.2018 17:42:22
 *
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
//для пагинации
use common\components\helpers\CustomStringHelper;
use common\widgets\listLinks\ListLinksWidget;
use common\widgets\materialList\MaterialListWidget;
use frontend\models\blog\articles\BlogArticles;


frontend\assets\PrismAsset::register($this);

//if(\Yii::$app->user->can(\common\components\rbac\Rbac::PERMISSION_ADMIN_PANEL)){
//echo "PHP: " . PHP_VERSION . '<br>';
//echo "ICU: " . INTL_ICU_VERSION . '<br>';
//echo "ICU Data: " . INTL_ICU_DATA_VERSION . '<br>';
//phpinfo();
//    //var_dump(\Yii::$app->formatter->asDateTime($article->createdAt, 'php:d F (D.) Yг. в Hч.iм.'));
//}

?>

<main class="col-md-9 col-sm-8 col-xs-12 col-xxs-12">
<!--
--------------------------------------------------------------------------------
                    post
--------------------------------------------------------------------------------
-->
    <article class="single_post row">
        <div class="single_post__header col-xxs-12 col-xs-12">
            <div class="bg-img">
                
                <?php echo Html::img(
                        CustomStringHelper::buildSrc(
                                Yii::$app->params['srcImgArticleBig'],
                                ['id_article' => $article->id,
                                    'src' => $article->faceImg,
                                ]
                        ),

                        ['alt' => $article->faceImgAlt,
                            'title' => $article->title,
                            'class' => 'single_post__header-main_img',
                        ]);
                ?>
                <div class="single_post__header-text">
                    <ul class="single_post__header-text-data">
                        
                    <!--comments-->
                    <?php //if ($article->hasComments()):?>
                        <!-- <li>
                            <a class="comment-trigger" href="">
                                <i class="fa fa-comment" aria-hidden="true"></i>
                                <span><?php //echo $countComments;?></span>
                            </a>
                        </li> -->
                    <?php //endif;?>    
                        
                        <li>
                            <i class="fa fa-eye" aria-hidden="true"></i>
                            <span><?php echo $article->viewCount; ?></span>
                        </li>
                    </ul>
 

                    <?php if ($article->hasTags()): ?>
                        <ul class="single_post__header-text-tags">
                        <?php foreach ($article->getBlogTags()->all() as $tag): ?>
                                <li><a href="<?= Url::toRoute(['/blog/tag', 'alias' => $tag->alias]); ?>" class="btn btn-default btn-xs"><?= $tag->title; ?></a></li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <h1 class="h_style_1 media-size text-stroke"><?= strip_tags(trim($article->title)); ?></h1>
                    <p class="h5 color-wite">
                        <?php if ($article->hasAuthor()): ?>
                        Автор: <a class="link-pic" href=""><strong><?php echo $article->author->username; ?></strong></a>
                        <?php endif; ?>
                        <span> | <?= CustomStringHelper::localeDataFormat($article->createdAt); ?></span>
                    </p>
                </div>
            </div>
        </div>
        
            <?php //echo $this->render('_facebook-likeButton');?>
            
        <!--text of article-->
        <div class="col-xxs-12 col-xs-12 single_post__content">

            <?php echo $article->text; ?>

        </div>
        
    </article>

    <div class="author_block">
        <div class="author_block-imgbox">
            <a class="author_block-imgbox-link" href="">
                <?php echo Html::img('@img-web-admins/1/sergio-coderius.jpg', ['class' => 'author_block-imgbox-img']); ?>
            </a>
        </div>
        
        <div class="author_block-contentbox">
            <h3 class="author_block-contentbox-title">Приветствую!</h3>
            <div class="author_block-contentbox-text">
                <p>Меня зовут Сергей. Я - автор этого блога.</p> 
                <p>Если Вам был полезен материал на моем сайте, поддержите пожалуйста мой проект, чтобы о нем узнали другие люди - кликните <span class="different_text">plizz :)</span> на иконку в соц. сети, 
                чтобы поделиться материалом с другими.</p>
                
            </div>
        </div>
        <div class="clear-block"></div>
        <div class="author_block-footer">
            <div class="author_block-footer-section to_left">
                <h4 class="author_block-footer-title">Поделиться:</h4>
                <ul class="author_block-footer-menubox">
                    <li>
                        <a class="icon-facebook rotate10deg hoverBorderLimon" data-myaction="myShare" rel="nofollow" href=""></a>
                    </li>
                    <li>
                        <a class="icon-google_plus rotate10deg hoverBorderLimon" data-myaction="myShare" rel="nofollow" href="https://plus.google.com/share?url=<?= Url::canonical(); ?>"></a>
                    </li>
                    <li>
                        <a class="icon-twitter rotate10deg hoverBorderLimon" data-myaction="myShare" rel="nofollow" href="http://twitter.com/share?text=Cool%20site%20by%20Coderius"></a>
                    </li>
                </ul>
            </div>
            
            <div class="author_block-footer-section to_right">
                <h4 class="author_block-footer-title">Связь:</h4>
                <ul class="author_block-footer-menubox">
                    <li>
                        <a class="icon-email rotatemin10deg hoverBorderLimon" data-myaction="myShare" rel="nofollow" href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=sunrise4fun@gmail.com&ui=2&tf=1&pli=1" target="_blank"></a>
                        
                    </li>
                    <li>
                        <!-- <a class="icon-skype rotatemin10deg hoverBorderLimon skype-button" data-myaction="myShare" data-contact-id="live:coderius_1" rel="nofollow" href=""></a> -->
                        <!--<span class="icon-skype skype-button" data-contact-id="live:coderius_1"></span>-->
                        <!--<a class="icon-skype rotatemin10deg hoverBorderLimon" data-myaction="myShare" rel="nofollow" href=""></a>-->
                    </li>
                </ul>
            </div>
            
        </div>
        
    </div>   

    

   <?php if ($article->hasSery()): ?>
        <?php $artList = \Yii::$app->sidebar->getRelativeArticlesBySeryToWidget($article->sery->id); ?>              
        <?= 
            count($artList) > 0 ? 
            ListLinksWidget::widget([
                'list' => \Yii::$app->sidebar->getRelativeArticlesBySeryToWidget($article->sery->id),
            ])
            :
            '';
        ?>

    <?php endif; ?>



<?= MaterialListWidget::widget([
    'query' => BlogArticles::find()
                    ->active()
                    ->category($article->idCategory)
                    ->orderRandom()
                    ->limit(6),

//    'layout' => "{header}\n{items}",

    'headerText' => 'Также по теме:',
//    'itemOptions' => function($model, $index){
//        return [
//            'data-link' => Url::toRoute(['/blog/article', 'alias' => $model->alias])
//        ];
//    },

    'itemViewParams' => [
        'image' => function ($model) {
            return Html::img("@img-web-blog-posts/{$model->id}/middle/{$model->faceImg}", ['alt' => '', 'title' => '', 'class' => 'linkbox-elem-img']);
        },
        'category' => function ($model) {
            return $model->hasCategory() ? $model->category->title : 'Без категории.';
        },
        'title' => function ($model) {
            return $model->title;
        },
        'date' => function ($model) {
            return \Yii::$app->formatter->asDateTime($model->createdAt, $pattern = 'php:d. M Y');
        },
        'linkPage' => function ($model) {
            return Url::toRoute(['/blog/article', 'alias' => $model->alias]);
        },
        'linkCategory' => function ($model) {
            return $model->hasCategory() ? Url::toRoute(['/blog/category', 'alias' => $model->category->alias]) : '#';
        },
    ],
    'on beforeRenderItem' => function ($event) use ($article) {
        if ($event->model->id === $article->id) {//чтобы не отобр. текущая запись
            $event->isValid = false;
        }
    },
    'on afterRenderItem' => function ($event) {
        $index = $event->indexElement + 1;

        if ($index % 3 == 0) {
            $event->result = '<div class="clearfix visible-lg visible-md"></div>';
        } elseif ($index % 2 == 0) {
            $event->result = '<div class="clearfix visible-sm"></div>';
        }
    },
]); ?>


    <?php 
    // echo \coderius\comments\widgets\commentsBlock\CommentWidget::widget([
    //         // 'assetDepends' => ['frontend\assets\AppAsset'],
    //         // 'materialAuthorId' => $article->hasAuthor() ? $article->author->id : false,
    //         'entity' => \Yii::$app->params['entities']['blog'],
    //         'entityId' => $article->id,
    //     ]);
    ?>

</main>

<div id="fb-root"></div>

<?php

//fasebook
$fb_shared_url = Url::canonical();

$js = <<<JS
        
//Обработка facebook share button
//--------------------------------    
//    $.ajaxSetup({ cache: true });   
//        
//    $.getScript('https://connect.facebook.net/en_US/sdk.js', function(){
//        FB.init({
//            appId            : '1811670458869631',
//            autoLogAppEvents : true,
//            xfbml            : true,
//            version          : 'v3.1'
//        }); 
//            
//        if (typeof FB != 'undefined'){
//            FB.ui({
//                method: 'share_open_graph',
//                action_type: 'og.likes',
//                action_properties: JSON.stringify({
//                  object:'https://developers.facebook.com/docs/javascript/examples',
//                })
//            },  function(response){
//                    // Debug response (optional)
//                    console.log(response);
//                }
//            ); 
//        } 
//    });
        
    $.ajax({
        url: 'https://connect.facebook.net/en_US/sdk.js',
        dataType: 'script',
        cache: true,
        success:function(script, textStatus, jqXHR)
        {
            FB.init({
                appId            : '1811670458869631',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v3.1'
            });

        }
    });
      
    $('.icon-facebook[data-myaction="myShare"]').on('click', function(e) {
        e.preventDefault();
        FB.ui({
            method: 'share',
            mobile_iframe: true,
            href: '$fb_shared_url',
            
        }, function(response){});
    });    
//=================================        
//Обработка facebook share button
//=================================       
 
//----------------------------------   
//Обработка гугл+ share button  
//----------------------------------        
    $('.icon-google_plus[data-myaction="myShare"]').on('click', function(e) {
        e.preventDefault();
        var width  = 550,
            height = 450,
            left   = ($(window).width()  - width)  / 2,
            top    = ($(window).height() - height) / 2,
            url    = this.href,
            opts   = 'status=1' +
                    ',width='  + width  +
                    ',height=' + height +
                    ',top='    + top    +
                    ',left='   + left   +
                    ',toolbar=0,location=0';

            window.open(url, 'google+', opts).focus();

            return false;
        
    });
//==================================   
//Обработка гугл+ share button  
//==================================        

//----------------------------------   
//Обработка твиттер share button  
//----------------------------------        
    $('.icon-twitter[data-myaction="myShare"]').on('click', function(e) {
        e.preventDefault();
        var width  = 550,
            height = 450,
            left   = ($(window).width()  - width)  / 2,
            top    = ($(window).height() - height) / 2,
            url    = this.href,
            opts   = 'status=1' +
                     ',width='  + width  +
                     ',height=' + height +
                     ',top='    + top    +
                     ',left='   + left;

            window.open(url, 'twitter', opts).focus();

            return false;
    });
//==================================   
//Обработка твиттер share button  
//==================================


//----------------------------------   
//Обработка gmail button  
//----------------------------------        
    $('.icon-email[data-myaction="myShare"]').on('click', function(e) {
        e.preventDefault();
        var width  = 550,
            height = 450,
            left   = ($(window).width()  - width)  / 2,
            top    = ($(window).height() - height) / 2,
            url    = this.href,
            opts   = 'status=1' +
                     ',width='  + width  +
                     ',height=' + height +
                     ',top='    + top    +
                     ',left='   + left;

            var myWind = window.open(url, 'gmail', opts).focus();
            
        
            return false;
    });
//==================================   
//Обработка gmail button  
//==================================   
        
        
// $('.icon-skype[data-myaction="myShare"]').on('click', function(e) {
//     e.preventDefault();
//     $('[allow]').show();
// });        
          
JS;

$this->registerCss('.lwc-chat-button{opacity: 0;}'); //прячем иконку скайпа

$this->registerJs($js, \yii\web\View::POS_READY);
// $this->registerJsFile('https://swc.cdn.skype.com/sdk/v1/sdk.min.js');
// $this->registerJsFile('http://www.skypeassets.com/i/scom/js/skype-uri.js');
$this->registerJsFile('https://apis.google.com/js/platform.js', ['async' => true, 'defer' => true]);

//$this->registerCss('[allow]{display:none}[allow].lwc-chat-frame{display:visible !important;}');

?>