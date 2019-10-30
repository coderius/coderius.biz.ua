<?php

/**
 * @package myblog
 * @file _content.php created 06.02.2018 18:12:48
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */

    use yii\widgets\Breadcrumbs;

?>

<!--
--------------------------------------------------------------------------------
                            Content
--------------------------------------------------------------------------------
-->
<?=
Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'options' => ['class' => 'breadcrumb', 'style' => ''],
]);
?>
<?= $content ?>




