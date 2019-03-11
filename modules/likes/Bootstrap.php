<?php
namespace modules\likes;

/**
 * @package myblog
 * @file Bootstrap.php created 30.05.2018 9:39:26
 * 
 * @copyright Copyright (C) 2018 Sergio coderius <coderius>
 * @license This program is free software: GNU General Public License
 */

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
            $this->controllerNamespace = 'modules\likes\\console';
        }
        
    }
}
