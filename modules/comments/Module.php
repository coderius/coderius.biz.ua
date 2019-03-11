<?php

/**
 * @package myblog
 * @file Module.php created 28.05.2018 20:24:52
 * 
 * @copyright Copyright (C) 2018 Sergio coderius <coderius>
 * @license This program is free software: GNU General Public License
 */

namespace modules\comments;

use Yii;
use yii\web\GroupUrlRule;
use modules\comments\traits\TranslationsTrait;

class Module extends \yii\base\Module
{
    use TranslationsTrait;
    
    /** @var string module name */
    public static $moduleName = 'comments';
    
    /** @var string|null */
    public $userIdentityClass = null;
    
    public $accessPlan;
    
    public $adminRbac = 'admin';
    
    const ACCESSPLAN_ALL = 'all';
    const ACCESSPLAN_USERS = 'users';
    
    /**
   
      In app config and console/config/main.php need include 
      'modules' => [
        'comments' => [
            'class' => 'modules\comments\Module',
        ],
    ],
    
    'bootstrap' => [
        'modules\comments\Bootstrap'
    ], 
     */
    public $controllerNamespace = 'modules\comments\controllers';
    
    public function init()
    {
        parent::init();

//        \Yii::configure($this, require __DIR__ . '/config/main.php');
        $this->registerTranslations();
        
//        $this->controllerMap = [
//            'hello' => \modules\comments\commands\HelloController::className()
//        ];
 
        //иначе ломает консольные комманды
        if(Yii::$app instanceof yii\web\Application){
            if ($this->userIdentityClass === null) {
                $this->userIdentityClass = \Yii::$app->getUser()->identityClass;
            }
        }
        
//        var_dump(Module::t('messages', 'No comments yet.'));die;
    }
    
    /**
     * Adds UrlManager rules.
     * @param Application $app the application currently running
     * @s
     * 
     * ince 0.2
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
    
    /**
     * Get default model classes
     */
    protected function getDefaultModels()
    {
        return [
            'Comments' => \modules\comments\models\Comments::className(),
            'CommentsQuery' => \modules\comments\models\CommentsQuery::className(),
            'CommentsForm' => \modules\comments\models\CommentsForm::className(),
            'CommentsSearch' => \modules\comments\models\CommentsSearch::className(),
        ];
    }
    
    public function model($name)
    {
        $models = $this->getDefaultModels();
        if(array_key_exists($name, $models)){
            return $models[$name];
        }
        return false;
    }
    
    
    
}