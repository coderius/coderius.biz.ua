<?php
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
//use common\widgets\Alert;
//var_dump($list); die;
$num = 1;

//var_dump(Yii::$app->controller->id);die;
?>

<!--relative posts widget-->
<div class="row relative_posts">
    <div class="col-xxs-12 col-xxs-12 col-xs-12"> 
        <h2 class="h_style_button">Читайте также из этой серии:</h2>
        <ul class="">
            <?php foreach ($list as $article): ?>
            <li>
            <?php if($article->alias === \Yii::$app->request->queryParams['alias'] && \Yii::$app->controller->id === 'blog' && \Yii::$app->controller->action->id === 'article'): ?>
                <span class="relative_posts_num--active"><?php echo $num++ . '.'; ?></span><span style="font-weight: bold"><?= $article->title; ?></span>
            <?php else: ?>
                <span class="relative_posts_num"><?php echo $num++ . '.'; ?></span><a href="<?= Url::toRoute(['/blog/article', 'alias' => $article->alias]); ?>"><?= $article->title; ?></a>
            <?php endif; ?>
            </li>    
            <?php endforeach; ?>
        </ul>
    </div>
</div>