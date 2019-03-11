<?php
use \yii\web\Request;
//use backend\models\blog\BlogArticles;
//use yii\db\ActiveRecord;
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

//yii\base\Event::on(BlogArticles::className(), ActiveRecord::EVENT_AFTER_INSERT, function ($event) {
//    \Yii::$app->frontendCache->delete('sitemap');
//});
//
//yii\base\Event::on(BlogArticles::className(), ActiveRecord::EVENT_AFTER_UPDATE, function ($event) {
//    \Yii::$app->frontendCache->delete('sitemap');
//});
//
//yii\base\Event::on(BlogArticles::className(), ActiveRecord::EVENT_AFTER_DELETE, function ($event) {
//    \Yii::$app->frontendCache->delete('sitemap');
//});

//var_dump($baseUrl); die;
//var_dump("-------------");
//die;
return [
    'id' => 'app-backend',
    'homeUrl' => (new Request)->getBaseUrl().'/admin/index',//for \Yii::$app->getHomeUrl() or $this->goHome()
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    
    'controllerMap' => [
        'blog-articles' =>[
                'class' =>'backend\controllers\blog\BlogArticlesController'
        ],
        'blog-categories' =>[
                'class' =>'backend\controllers\blog\BlogCategoriesController'
        ],
        'blog-series' =>[
                'class' =>'backend\controllers\blog\BlogSeriesController'
        ],
        'blog-tags' =>[
                'class' =>'backend\controllers\blog\BlogTagsController'
        ],
        'navigation-top' => [
            'class' => 'backend\controllers\fragments\NavigationTopController'
        ]
    ],    
    
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'locale' => 'ru-RU',
            'timeZone' => 'Europe/Kiev', // +4 UTC
            //нужен для конвертации дат в локальное время. 
            //В базе сохраняем с помощью gmdate("Y-m-d H:i:s"). 
            //Потом в виде выводим  \Yii::$app->formatter->asDateTime($model->updatedAt). 
            //Если не устанавливать тут свойство, то тогда в виде выводим  \Yii::$app->formatter->asDateTime($model->updatedAt. " UTC"). 
            //Если нужно где-то в приложении поменять временную зону, то меняем так \Yii::$app->timeZone = 'Europe/Kiev';
            'defaultTimeZone' => 'UTC',
            'dateFormat' => 'd MMMM yyyy',//как месяц
            //'dateFormat' => 'dd.MM.yyyy',// как число
            'datetimeFormat' => 'php:n F Y в H:i',
            'timeFormat' => 'H:i:s',
        ],
        
        'frontendCache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => Yii::getAlias('@frontend') . '/runtime/cache'
        ],
        
        'request' => [
            'csrfParam' => '_csrf-user',
            'baseUrl' => $baseUrl.'/backend/web',
            'cookieValidationKey' => 'sgtjngjgkl,mnbcxvzcvbnjjjh7654hgbbvc',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\user\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
//                'name' => '_identity-backend', 
                'name' => '_identity-user',
                'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
//            'name' => 'advanced-backend',
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
            'errorAction' => 'base-admin/error',
        ],
        'urlManager' => require(__DIR__ . '/urlmanager.php'),
    ],
    
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
                [
                    'allow' => true,
                    'roles' => [\common\components\rbac\Rbac::PERMISSION_ADMIN_PANEL],
                ],

        ],
        'denyCallback' => function ($rule, $action) {
            \Yii::$app->session->setFlash('danger', 'Доступно только для админа!');
            return \Yii::$app->response->redirect(Yii::$app->urlManagerFrontend->createUrl(['/login']));
        },
        
        
    ],
    
    'params' => $params,
];
