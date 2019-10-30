<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use common\components\rbac\Rbac;

/* @var $exception \yii\web\HttpException|\Exception */
/* @var $handler \yii\web\ErrorHandler */
if ($exception instanceof \yii\web\HttpException) {
    $code = $exception->statusCode;
} else {
    $code = $exception->getCode();
}
$name = $handler->getExceptionName($exception);
if ($name === null) {
    $name = 'Error';
}
if ($code) {
    $name .= " (#$code)";
}

if ($exception instanceof \yii\base\UserException) {
    $message = $exception->getMessage();
} else {
    $message = 'An internal server error occurred.';
}

$this->title = $name;

?>
<div class="site-error">

    <h1><?= $handler->htmlEncode($name) ?></h1>
    <h2><?= nl2br($handler->htmlEncode($message)) ?></h2>
    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>
    <div class="version">
        <?= date('Y-m-d H:i:s', time()) ?>
    </div>
</div>
<?php if(Yii::$app->user->can(Rbac::PERMISSION_ADMIN_PANEL)): ?>
<?php foreach($exception->getTrace() as $t): ?>

<?php var_dump($t); ?>

<?php endforeach; ?>
<?php endif; ?>

<?php $style= <<< CSS
// CSS code here 
body {
    font: normal 9pt "Verdana";
        color: #000;
        background: #fff;
    }

    h1 {
        font: normal 18pt "Verdana";
        color: #f00;
        margin-bottom: .5em;
    }

    h2 {
        font: normal 14pt "Verdana";
        color: #800000;
        margin-bottom: .5em;
    }

    h3 {
        font: bold 11pt "Verdana";
    }

    p {
        font: normal 9pt "Verdana";
        color: #000;
    }

    .version {
        color: gray;
        font-size: 8pt;
        border-top: 1px solid #aaa;
        padding-top: 1em;
        margin-bottom: 1em;
    }
        
        
CSS;
 $this->registerCss($style);
?>