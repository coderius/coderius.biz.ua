<?php

/**
 * @package myblog
 * @file _searchform.php created 05.03.2018 21:42:54
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */

use yii\helpers\Html;
use yii\helpers\Url;


//На рабочем сервере в форме ставим Url::toRoute(['/search/'], 'https')

?>

<!--<form class="" action="/search" method="get">    
    <input type="text" name="search" placeholder = "Поиск...">
    <button type="submit"><i class="fa fa-search"></i></button>
</form>-->

<?= Html::beginForm(Url::toRoute(['/search/'], YII_WORK_SERVER ? 'https' : 'http'), 'get', ['class' => 'search-form']) ?>

<?= Html::textInput('q', null, ['placeholder' => "Поиск..."]) ?>
<?= Html::submitButton("<i class=\"fa fa-search\"></i>", ['class' => 'submit']) ?>

<?= Html::endForm() ?>

<?php 
//Так как браузер кодирует строку гет запроса, то чтобы перевести урл в читабельный вид с 
//разделителем в качестве плюса создан скрипт ниже
//
$js = <<< JS
    $('.search-form').on('submit', function(e){
        e.preventDefault();
        var action = $(this).prop( 'action' );
        var input = $(this).find('input[name=q]').val().trim().split(/\s/).join('+');
        var newUrl = action + '?q=' + input;
        $(location).attr('href', newUrl);
//        console.log(newUrl);
    });
        
               
JS;


Yii::$app->getView()->registerJs($js, yii\web\View::POS_READY);

?>