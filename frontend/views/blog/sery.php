<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\helpers\BaseStringHelper;
use yii\widgets\LinkPager;//для пагинации
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\data\Pagination;
use common\components\helpers\CustomStringHelper;

$this->params['breadcrumbs'][] = Html::decode($sery->title);


?>
<h1 class="col-xs-12 h_style_1">Серия: <a href="<?= Url::toRoute(['/blog/sery', 'alias' => $sery->alias]); ?>"><?= $sery->title;?></a></h1>

<main class="col-md-9 col-sm-8 col-xs-12 col-xxs-12">
    <?= $this->render('//blog/_material-list', 
        compact(
                'articles',
                'confLinkPager'
                ));
    ?>
    
    <!--pagination-->
    <div class="row">
        <div class="col-xs-12">
            <?php echo LinkPager::widget($confLinkPager); ?>
            
            
        </div>    
    </div>
    
</main>