<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?= Html::csrfMetaTags() ?>

<title><?= Html::encode($this->title ? $this->title ." | ".\Yii::$app->name : \Yii::$app->name) ?></title>

<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="container-fluid top-container">
    

    
    <?php echo $this->render('//layouts/base/fragments/_header', [
        'nav' => \Yii::$app->fragmentHeader->topNav,
    ]) ?>
    <?php //echo \Yii::$app->fragmentHeader->buildTopNav('//layouts/base/fragments/_header'); ?>
    <!--------------------------------------------------------------------------
                                center block
    ----------------------------------------------------------------------------
    -->
    <div class="row centerBox">
        
    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
        <div class="alert alert-<?php echo $key; ?>" data-alert="alert"> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong><?= $message; ?></strong>
         
        </div>
        
    <?php endforeach; ?>    
        
    <?= $content ?>

    </div>
    


</div>
    
<?= $this->render('//layouts/base/fragments/_footer') ?>

<?php $this->endBody() ?>
<?php echo $this->render('//layouts/base/fragments/_counter') ?>    
</body>
</html>
<?php $this->endPage() ?>
