<?php

/**
 * @package myblog
 * @file main.php created 25.03.2018 20:22:24
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */

use yii\widgets\Breadcrumbs;

?>

<?php $this->beginContent('@app/views/layouts/base/_template.php'); ?>

<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'options' => ['class' => 'breadcrumb', 'style' => ''],
]);?>

<div class="centerBox-wrap">
    
<?= $content ?>

</div>    
<?php $this->endContent(); ?>