<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'frontend\bootstrap\SetUp',
        
        ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'seo' => [
           'class' => 'frontend\fragments\SeoComponent',
//            'temp' => \frontend\components\view\SideBarComponent::BASE_TEMP,
	],
        //my component
        'sidebar' => [
           'class' => 'frontend\fragments\SideBarComponent',
//            'temp' => \frontend\components\view\SideBarComponent::BASE_TEMP,
	],
        'fragmentHeader' => [
           'class' => 'frontend\fragments\HeaderComponent',
//            'temp' => \frontend\components\view\SideBarComponent::BASE_TEMP,
	],
        
        'adminPanel' => [
           'class' => 'frontend\fragments\AdminPanel',
//            'temp' => \frontend\components\view\SideBarComponent::BASE_TEMP,
	],
        
        'request' => [
            'csrfParam' => '_csrf-user',
            'baseUrl' => $baseUrl,
            'cookieValidationKey' => 'sdifdbfshbsnstyrfedwety,mnbvcdsfe',
        ],
        
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\user\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
//                'name' => '_identity-frontend', 
                'name' => '_identity-user',
                'httpOnly' => true],
        ],
        
        'assetManager' => [
            'appendTimestamp' => YII_DEBUG ? false : true,//кэширование ресурсов по версии
            'bundles' => [
//                'yii\web\JqueryAsset' => [
//                    'js' => []
//                ],
//                'yii\bootstrap\BootstrapPluginAsset' => [
//                    'js' => []
//                ],
                //отключаем родной бутстрап
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
//            'name' => 'advanced-frontend',
            'name' => 'advanced-site',
        ],
        
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => require(__DIR__ . '/urlmanager.php'),
    ],
    'params' => $params,
    
];
