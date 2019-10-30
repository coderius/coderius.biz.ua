<?php

namespace modules\likes\widgets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class likeBtnAsset extends AssetBundle
{
    public $sourcePath = (__DIR__ . '/assets');
    
    public $css = ["css/jquery.thumbs.css"];
    public $js = ["js/jquery.thumbs.js"];
    
    public $jsOptions = [
        'position' => \yii\web\View::POS_END,
    ];
    
    public $depends = [
        "frontend\assets\AppAsset"
    ];
    
    public $publishOptions = [
        'forceCopy' => true,
    ];
    
    public function init()
    {
        
        parent::init();
    }
    
//    protected function setupAssets($type, $files = [])
//    {
//        if ($this->$type === self::KRAJEE_ASSET) {
//            $srcFiles = [];
//            $minFiles = [];
//            foreach ($files as $file) {
//                $srcFiles[] = "{$file}.{$type}";
//                $minFiles[] = "{$file}.min.{$type}";
//            }
//            $this->$type = YII_DEBUG ? $srcFiles : $minFiles;
//        } elseif ($this->$type === self::EMPTY_ASSET) {
//            $this->$type = [];
//        }
//    }
    
    
}
