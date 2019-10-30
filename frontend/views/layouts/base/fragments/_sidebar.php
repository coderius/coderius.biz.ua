<?php

/**
 * @package myblog
 * @file _sidebar.php created 06.02.2018 17:59:42
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */
use common\widgets\sidebar\categories\CategoriesSideBarWidget;
use common\widgets\sidebar\tags\TagsSideBarWidget;
use common\widgets\sidebar\bestMaterials\BestMaterialsSideBarWidget;
use coderius\dynamicDontentMenu\Menu;
//\Yii::$app->sidebar->show();
?>

<!--
--------------------------------------------------------------------------------
                            sidebar
--------------------------------------------------------------------------------
-->
<aside class="col-md-3 col-sm-4 col-xs-12 col-xxs-12">



    <div id="sideicons" class="sideblock">
        <div class="sideicons-wrap">
            <a class="socIcon rssIcon" rel="alternate nofollow" type="application/rss+xml" href="http://feeds.feedburner.com/coderiusIT" title="Подпишись на новые записи блога по RSS" target="_blank"></a>
            <a class="socIcon facebookIcon" rel="nofollow" href="https://www.facebook.com/sergio.codev.1" title="Я в facebook" target="_blank"></a>
        </div>
    </div>
    
    
    <?php if($cds = \Yii::$app->sidebar->getCategoriesDataSidebar()): ?>
        <?= CategoriesSideBarWidget::widget([
            'title' => 'Разделы блога',
            'list' => $cds
        ]); ?>
    <?php endif; ?>
    <?= Menu::widget(
            [
                'clientOptions' => [
                    'selectors' => "h1, h2, h3, .h_style_3",
                    'extendPage'=> false // do not increase page height
                ]
            ]
        );
    ?>
    <?php if($tds = \Yii::$app->sidebar->getTagsDataSidebar()): ?>
        <?= TagsSideBarWidget::widget([
            'title' => 'Ключевые слова',
            'list' => $tds
        ]); ?>
    <?php endif; ?>
    
    <?php if($bm = \Yii::$app->sidebar->getBestBlogMaterialsSidebar()): ?>
        <?= BestMaterialsSideBarWidget::widget([
            'title' => 'Самое популярное',
            'list' => $bm
        ]); ?>
    <?php endif; ?>

    
    
</aside>