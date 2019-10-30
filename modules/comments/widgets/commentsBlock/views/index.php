<?php

use yii\widgets\ListView;
use yii\helpers\Html;

?>


<div id="loader">
    <?php echo Html::img('../assets/images/im7.gif', ['class' => '']); ?>
</div>
<!-- Contenedor Principal -->
<div id="ajax-comments-container" class="comments-container">
    <h3><?= $title; ?></h3>
    <hr>
    <!--<ul id="comments-list" class="comments-list">-->
        
        <?= 
            ListView::widget([
                'dataProvider' => $commentsProvider,
                'emptyText' => $emptyText,
                'layout' => "<ul id='comments-list' class='comments-list level-1'>{items}</ul>\n{pager}",
                'itemView' => '_list',
                'itemOptions' => [
                    'tag' => false,
                ],
                'viewParams' => [
                    'maxLevel' => $maxLevel,
                    'materialAuthorId' => $materialAuthorId,
                    
                    
                ],
                'options' => [
                    'tag' => false,
                ],
            ]); 
        ?>
        
    <!--</ul>-->
    
    <?php if (!Yii::$app->user->isGuest || true) : ?>
    <?php echo $this->render('_form', [
        'commentFormModel' => $commentFormModel,
        'formId' => $formId,
        'encryptedEntity' => $encryptedEntity,
        'formTitle' => $formTitle,
    ]); ?>
<?php endif; ?>
    
</div>

