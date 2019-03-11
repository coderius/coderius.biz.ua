<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;



?>

<div class="comment-form-container">
    <hr>
    <h3><?= $formTitle; ?></h3>
    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => $formId,
            'class' => 'comment-form',
            
        ],
        'action' => Url::toRoute(['/comments/default/ajax-create', 'entity' => $encryptedEntity]),
        'validateOnChange' => true,
        'validateOnBlur' => true,
//        'enableAjaxValidation' => true,
    ]); ?>

    <?php if(Yii::$app->user->isGuest): ?>
        <?php echo $form->field($commentFormModel, 'said_name', ['template' => '{input}{error}'])->input('text',['placeholder' => Yii::t('comments/messages', 'Add a name...')]); ?>
        <?php echo $form->field($commentFormModel, 'said_email', ['template' => '{input}{error}'])->input('text',['placeholder' => Yii::t('comments/messages', 'Add a email...')]); ?>
    <?php endif; ?>
    <?php echo $form->field($commentFormModel, 'content', ['template' => '{input}{error}'])->textarea(['placeholder' => Yii::t('comments/messages', 'Add a comment...'), 'rows' => 4, 'id' => 'comment-form_content', 'data' => ['comment' => 'content']]); ?>
    <?php echo $form->field($commentFormModel, 'parentId', ['template' => '{input}'])->hiddenInput(['data' => ['comment' => 'parent-id']]); ?>
    <?php //if(Yii::$app->user->isGuest): ?>
        <?= $form->field($commentFormModel, 'verifyCode')
            ->widget(Captcha::className(), [
                'captchaAction' => Url::toRoute(['comments/default/captcha']),
//                'template' => '{image}{input}',
                'options' => [
                    'placeholder'=>'Введите буквы с картинки'
                ],
            ]) ?>
    
    <?php //endif; ?>
        <br>
    <div class="comment-box-partial">
        <div class="button-container show">
            <?php echo Html::a(Yii::t('comments/messages', 'Cancel reply.'), '#', ['id' => 'cancel-reply', 'class' => 'pull-right btn btn-default', 'data' => ['action' => 'cancel-reply']]); ?>
            <?php echo Html::submitButton(Yii::t('comments/messages', 'Comment'), ['class' => 'btn btn-primary comment-submit']); ?>
        </div>
    </div>
    <?php $form->end(); ?>
    <div class="clearfix"></div>
</div>
