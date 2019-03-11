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

<div id="sidebest" class="sideblock">
    <div class="sideblock-header">
        <p>
            <i class="fa fa-tags"></i>
        </p>

        <h3 class="h_sidebar"><?= $title; ?></h3>
    </div>
    <ul>
        <?php foreach($list as $k => $v): ?>
        <li>
            <a href="<?= Url::toRoute(['/blog/article', 'alias' => $v['alias']]); ?>">
                <p class="sidebest-num"><?= $num++; ?></p>
                <div class="sidebest-cont">
                    <p class="sidebest-cont-title"><?= $v['title']; ?></p>
                    <p class="sidebest-cont-date">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                        <span><?= $v['viewCount']; ?></span>
                    </p>
                </div>

            </a>
        </li>

        <?php endforeach; ?>
        
        

    </ul>
</div>

