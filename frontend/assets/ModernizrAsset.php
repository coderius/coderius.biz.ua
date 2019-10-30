<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ModernizrAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];
    
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
    
    public $depends = [
        
    ];
    
    public function init()
    {
        
        if (YII_ENV_DEV)
        {
            $this->js = [
                'js/modernizr.js',
                
                
            ];
        }else if(!YII_ENV_DEV){
            
            
            $this->js = [
                'js/modernizr.js',
            ];
        }
        
        parent::init();
    }
    
    
}
