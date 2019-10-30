<?php
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
//use common\widgets\Alert;
//var_dump($list); die;
$num = 1;
?>

<!--SideCategoriesWidget widget-->
<div id="sidetags" class="sideblock">
    <div class="sideblock-header">
        <p>
            <i class="fa fa-tags"></i>
        </p>

        <h3 class="h_sidebar"><?= $title; ?></h3>
    </div>
    <ul>
        
        <?php foreach($list as $value): ?>
            <li><a title="Кол-во материалов : <?= $value['count']; ?>" style="font-size: <?= $value['rem']; ?>rem" href="<?= Url::toRoute(['/blog/tag', 'alias' => $value['alias']]); ?>"><?= $value['title']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>

