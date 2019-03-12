<?php

$params = array_merge(
    require __DIR__.'/../../common/config/params.php',
    require __DIR__.'/../../common/config/params-local.php',
    require __DIR__.'/params.php',
    require __DIR__.'/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'session' => [ // for use session in console application
            'class' => 'yii\web\Session',
        ],

        'request' => [
            'class' => 'yii\console\Request', //явно указал
        ],
    ],

    // 'modules' => [
    //     // 'comments' => [
    //     //     'class' => 'modules\comments\Module',
    //     // ],
    // ],

    // 'bootstrap' => [
    //     'modules\comments\Bootstrap',
    // ],

    'on beforeRequest' => function () {
        return null;
    },

    'params' => $params,
];
