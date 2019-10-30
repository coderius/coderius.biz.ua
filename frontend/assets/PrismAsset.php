<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class PrismAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'plugins/prism/prism.css',
        'plugins/prism/custom-prism.css',
    ];
    
    public $js = [
        'plugins/prism/prism.js'
    ];
    
    public $jsOptions = [
        'position' => \yii\web\View::POS_END,
    ];
    
    public $depends = [
        AppAsset::class,
    ];
    
    public function init()
    {
        //добавим класс для подключения стилей номеров строк
        $js = <<< JS
            $('code').parent('pre').addClass('line-numbers');    
JS;
        $view = \Yii::$app->getView();
        $view->registerJs( $js, $position = $view::POS_END, $key = null );
        
        parent::init();
    }
    
    
}
