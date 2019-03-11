<?php

namespace modules\comments\widgets\commentsBlock;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class CommentAsset extends AssetBundle
{
    public $sourcePath = (__DIR__ . '/assets');
    
    public $css = [
        "plugins/trumbowyg/ui/trumbowyg.min.css",
        "styles/css/comments.css",
    ];
    
    public $js = [
        "plugins/trumbowyg/trumbowyg.min.js",
        "plugins/trumbowyg/langs/ru.min.js",
        "plugins/trumbowyg/plugins/preformatted/trumbowyg.preformatted.min.js",
//        "https://www.google.com/recaptcha/api.js",
        "js/comments.js",
        
    ];
    
    public $jsOptions = [
        'position' => \yii\web\View::POS_END,
    ];
    
    public $depends = [
//        "frontend\assets\AppAsset"
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
