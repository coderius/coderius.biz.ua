<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\enum\NavigationTopEnum;
use backend\models\fragments\NavigationTop;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\fragments\NavigationTop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="navigation-top-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parentId')->dropDownList(
                    ArrayHelper::merge(
                            ArrayHelper::map(NavigationTop::find()->all(), 'id', 'title'),
                            [0 => 'Без родителя']
                            ), 
                    ['prompt'=>'Выбрать родителя']); ?> 

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orderByNum')->textInput() ?>
    
    <?= $form->field($model, 'status')->dropDownList(
                    NavigationTopEnum::$statusesName, 
                    ['prompt'=>'Назначить статус']); ?>
    
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/admin', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
