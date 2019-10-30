<?php
namespace modules\comments;


use yii\base\BootstrapInterface;
use yii\base\Application;
use yii\console\Application as ConsoleApplication;
use yii\web\Application as WebApplication;


class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
//        var_dump($app instanceof WebApplication); die;
        $module = Module::instance();
        
        if ($app instanceof WebApplication) {
            $module->addUrlManagerRules($app);
        } elseif ($app instanceof ConsoleApplication) {
            $module->controllerNamespace = 'modules\comments\commands';
            
        }
        
    }
}
