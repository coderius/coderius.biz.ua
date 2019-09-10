<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

require __DIR__.'/../../vendor/autoload.php';
require __DIR__.'/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__.'/../../common/config/bootstrap.php';
require __DIR__.'/../config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__.'/../../common/config/main.php',
    require __DIR__.'/../../common/config/main-local.php',
    require __DIR__.'/../config/main.php',
    require __DIR__.'/../config/main-local.php'
);
if (extension_loaded('xhprof')) {
    include_once '/xhprof/xhprof_lib/utils/xhprof_lib.php';
    include_once '/xhprof/xhprof_lib/utils/xhprof_runs.php';
     
    xhprof_enable(XHPROF_FLAGS_CPU);
}
(new yii\web\Application($config))->run();

if (extension_loaded('xhprof')) {
    $profilerNamespace = 'ЗДЕСЬ_ИМЯ_ПРОФИЛИРУЕМОГО_СКРИПТА';
    $xhprofData = xhprof_disable();
    $xhprofRuns = new XHProfRuns_Default();
    $runId = $xhprofRuns->save_run($xhprofData, $profilerNamespace);
}