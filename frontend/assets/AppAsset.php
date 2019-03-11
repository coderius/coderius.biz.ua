<?php

namespace frontend\assets;

use yii;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];
    
    public $jsOptions = [
        'position' => \yii\web\View::POS_END,
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        ModernizrAsset::class,//для использования медиа запросов в скрипте
        //bootstrap генерируем в scss в один файл main.css
//        'yii\bootstrap\BootstrapAsset',
    ];
    
    public function init()
    {
        if (YII_ENV_DEV)
        {
            $this->css = [
                'styles/css/main.css',
//                'plugins/highlight/styles/magula.css'
            ];
            
            $this->js = [
                'js/main.js',
                'js/bootstrap.min.js'
//                'plugins/highlight/highlight.pack.js'
            ];
            
            
        }else if(!YII_ENV_DEV){
            $this->css = [
                'styles/css-min/main.min.css',
            ];
            
            $this->js = [
                'js/main.js',
                'js/bootstrap.min.js'
            ];
        }
        
        parent::init();
    }
    
    
}
