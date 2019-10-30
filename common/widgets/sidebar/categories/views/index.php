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
<div id="sidemenu" class="sideblock">
    <div class="sideblock-header">
        <p>
            <i class="fa fa-bookmark"></i>
        </p>

        <h3 class="h_sidebar"><?= $title; ?></h3>
    </div>
    <ul>
        <?php foreach($list as $value): ?>
            <li><span class="fa fa-angle-right"></span><a href="<?= Url::toRoute(['/blog/category', 'alias' => $value['alias_category']]); ?>"><?= $value['name_category'];?> <span>(<?= $value['count_materials'];?>)</span></a></li>
        <?php endforeach; ?>
    </ul>
</div>

