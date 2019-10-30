<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = $name;
?>
<h1 class="col-xs-12 h_style_1"><?= Html::encode($this->title) ?></h1>

<main class="col-md-9 col-sm-8 col-xs-12 col-xxs-12">
    
<div class="alert alert-danger">
      <span class="h3">
        Где-то ошибка. <?= nl2br(Html::encode($message)); ?> - <a href="<?= Url::home(true); ?>">на главную</a>
    </span>  
</div>






</main>