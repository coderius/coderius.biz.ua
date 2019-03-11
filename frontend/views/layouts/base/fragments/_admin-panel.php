<?php

/**
 * @package myblog
 * @file _admin-panel.php created 11.08.2018 16:56:44
 * 
 * @copyright Copyright (C) 2018 Sergio coderius <coderius>
 * @license This program is free software: GNU General Public License
 */
use common\enum\BlogEnum;
use yii\helpers\Html;
use yii\helpers\Url;

//var_dump(Yii::$app->request->queryParams['alias']);


?>
&nbsp;&nbsp; <a title="Вход" href="<?= Yii::$app->urlManagerBackend->createUrl(['admin/index']); ?>">Админ часть</a>
&nbsp;&nbsp; 
<?php //echo Html::tag('span', BlogArticles::$statusesName[$model->flagActive],['class' => 'label label-' . ($active ? 'success' : 'danger'),]); ?>


<?php if(Yii::$app->controller->id === 'blog' && Yii::$app->controller->action->id === 'article'): ?>
    <?php 
        $alias = Yii::$app->request->queryParams['alias'];
        $article = Yii::$app->adminPanel->getBlogArticle($alias);
        
        if($article){
            
            echo Html::tag('span', BlogEnum::$statusesName[$article->flagActive],['class' => 'label label-' . ($article->isActive ? 'success' : 'danger'),]);
            echo '&nbsp;&nbsp;';
            echo Html::a(Html::tag('span', 'Редактировать',['class' => 'label label-info', 'target' => '_blank']), Yii::$app->urlManagerBackend->createUrl(["blog-articles/update?id=$article->id"]));
        }
        
    ?>



<?php endif; ?>
