<?php

namespace modules\comments\traits;

use Yii;
use modules\comments\Module;
/**
 * 
 */
trait TranslationsTrait
{
    public function registerTranslations()
    {
        \Yii::$app->i18n->translations['comments*'] = [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => dirname(__DIR__) .'/translations',
                    //'sourceLanguage' => 'en-US',
                    'forceTranslation' => true,
                    'fileMap' => [
                        'comments/messages'  => 'messages.php',
                    ],
                
        ];
    }
    
    public static function t($category, $message, $params = [], $language = null)
    {
//        var_dump(dirname(__DIR__) .'/translations');die;
        return Yii::t('comments/' . $category, $message, $params, $language);
    }
    
}