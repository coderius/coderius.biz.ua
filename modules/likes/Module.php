<?php

/**
 * @package myblog
 * @file Module.php created 28.05.2018 20:24:52
 * 
 * @copyright Copyright (C) 2018 Sergio coderius <coderius>
 * @license This program is free software: GNU General Public License
 */

namespace modules\likes;


use yii\web\GroupUrlRule;


class Module extends \yii\base\Module
{
    /** @var string module name */
    public static $moduleName = 'likes';
    
    /** @var string|null */
    public $userIdentityClass = null;
    
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'modules\likes\controllers';
    
    public function init()
    {
        parent::init();

        if ($this->userIdentityClass === null) {
            $this->userIdentityClass = \Yii::$app->getUser()->identityClass;
        }
        
        // ... остальной инициализирующий код ...
    }
    
        /**
     * Adds UrlManager rules.
     * @param Application $app the application currently running
     * @since 0.2
     */
    public function addUrlManagerRules($app)
    {
        $app->urlManager->addRules([new GroupUrlRule([
                'prefix' => $this->id,
                'rules' => require __DIR__ . '/url-rules.php',
            ])], true);
        
//        var_dump(\Yii::$app->urlManager);
    }
    
    /**
     * @return static
     */
    public static function instance()
    {
        return \Yii::$app->getModule(static::$moduleName);
    }
    
}