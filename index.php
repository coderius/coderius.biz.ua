<?php
//$start = microtime(true);

// comment out the following two lines when deployed to production
//defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');

require(__DIR__ . '/../env.php');

require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();

//$end = microtime(true);
//$res = $end - $start;
//echo "<br/> Время выполнения php скрипта в микросекундах:". 1000 * round($res,4) . " миллисекунд";