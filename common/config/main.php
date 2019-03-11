<?php
use \yii\web\Request;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());
$baseUrl = str_replace('/backend/web', '', $baseUrl);


require dirname(dirname(__DIR__)) . '/defines.php';
//var_dump(YII_WORK_SERVER);

$conf =  [
    'aliases' => require(__DIR__ . '/aliases.php'),
    'name' => 'Coderius',
    'language' =>'ru-RU',
    'timeZone' => 'Europe/Kiev',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        
        'myRequest' => [
            'class' => 'common\components\web\Request'//мой компонент
        ],
        
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        
        // перевод
        'i18n' => [
            'translations' => [
                'blog*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    //'sourceLanguage' => 'en-US',
                    'forceTranslation' => true,
                    'fileMap' => [
                        'blog-main'  => 'blog.php',
                    ],
                ],
                
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    //'sourceLanguage' => 'en-US',
                    'forceTranslation' => true,
                    'fileMap' => [
                        'app'       => 'app.php',
                        'app/error' => 'error.php',
                        'app/admin' => 'admin.php',
                    ],
                ],
            ],
        ],
        
        'geoip' => ['class' => 'coderius\geoIp\GeoIP'],
        
        //формат даты
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'locale' => 'ru-RU',//язык русский
            'defaultTimeZone' => 'UTC',//точка отсчета
            'timeZone' => 'Europe/Kiev',
//            'timeZone' => Yii::$app->user->isGuest ? 'UTC' : Yii::$app->user->identity->timezone,
            
            //'dateFormat' => 'd MMMM yyyy',//как месяц
            'dateFormat' => 'dd.MM.yyyy',// как число

        ],
        
        
        
        //для ссылок в админки во фронт и на оборот
        'urlManagerFrontend' => require(dirname(dirname (__DIR__ )).'/frontend/config/urlmanager.php'),
        'urlManagerBackend' =>  require(dirname(dirname (__DIR__ )).'/backend/config/urlmanager.php'),

        
        
    ],
    
    'modules' => [
//        'likes' => [
//            'class' => 'modules\likes\Module',
//            // ... другие настройки модуля ...
//        ],
        
        'debug' => [
            'class' => 'yii\debug\Module',
//            'allowedIPs' => ['127.0.0.1', '::1']
        ]
    ],
    
    
    //динамически устанавливаем часовой пояс для посетителя
    'on beforeRequest' => function () {
        $ip = Yii::$app->geoip->ip(Yii::$app->request->userIP);
        
        if($ip->hasResult()){
            //Yii::$app->setTimeZone($ip->location->timeZone);
            Yii::$app->setTimeZone('Europe/Kiev');
        }
        else{
            Yii::$app->setTimeZone('Europe/Kiev');
        }
//        var_dump(Yii::$app->timeZone);
        
        $debug = \Yii::$app->getModule('debug');
//        $debug->allowedIPs = [''];
        if(!\Yii::$app->user->isGuest){
            if(\Yii::$app->user->can(\common\components\rbac\Rbac::PERMISSION_ADMIN_PANEL)){
                
                $debug->allowedIPs = ['*'];
            }
        }
        
    },
            
    'bootstrap' => [
//        'modules\likes\Bootstrap',
        'common\components\events\EventBootstrap',
    ],        
            
            
];

if(!YII_WORK_SERVER){
    $conf['modules']['comments'] = [
            'class' => 'modules\comments\Module',
            'accessPlan' => modules\comments\Module::ACCESSPLAN_ALL,
        ];
    
    $conf['bootstrap'][] = 'modules\comments\Bootstrap';
    
}    

//var_dump($conf);die;

return $conf;    