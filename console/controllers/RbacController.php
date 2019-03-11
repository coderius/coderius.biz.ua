<?php

/**
 * @package myblog
 * @file RbacController.php created 31.03.2018 15:57:18
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\components\rbac\Rbac;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();//На всякий случай удаляем старые данные из БД...
        
        // добавляем разрешение "createPost"
        $useAdminPanel = $auth->createPermission(Rbac::PERMISSION_ADMIN_PANEL);
        $useAdminPanel->description = 'Use admin panel';
        $auth->add($useAdminPanel);

        // добавляем роль "author" и даём роли разрешение "createPost"
        $user = $auth->createRole(Rbac::ROLE_USER);
        $auth->add($user);

        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $admin = $auth->createRole(Rbac::ROLE_ADMIN);
        $auth->add($admin);
        $auth->addChild($admin, $useAdminPanel);
        $auth->addChild($admin, $user);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        $auth->assign($admin, 1);
        
        $this->stdout('Done!' . PHP_EOL);
    }
}