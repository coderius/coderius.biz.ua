<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\blog\BlogCategories;
use backend\models\blog\BlogSeries;
use backend\models\blog\BlogArticles;
use backend\models\blog\BlogTags;
use kartik\file\FileInput;
use dosamigos\tinymce\TinyMce;
use yii\web\JsExpression;

//var_dump(BlogArticles::$statusesName);
/* @var $this yii\web\View */
/* @var $model backend\models\blog\BlogArticles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-articles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'selectedCategory')
            ->dropDownList(
                    ArrayHelper::map(BlogCategories::find()->all(), 'id', 'title'), 
                    ['prompt'=>'Выбрать категорию']); ?>

    <?= $form->field($model, 'selectedSery')
            ->dropDownList(
                    ArrayHelper::map(BlogSeries::find()->all(), 'id', 'title'), 
                    ['multiple'=>'multiple','style' => 'height: 50px','prompt'=>'Выбрать cерию']); ?>
    
    <?= $form->field($model, 'selectedTags')
            ->dropDownList(
                    ArrayHelper::map(BlogTags::find()->all(), 'id', 'title'), 
                    ['multiple'=>'multiple',
                        'style' => 'height: 100px',
//                        'class'=>'',
                        'prompt'=>'Выбрать теги'
                    ]); ?>
    
    
    
    <?php // echo $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'metaTitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'metaDesc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'metaKeywords')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(TinyMce::className(), [
    'options' => ['rows' => 12],
    'language' => 'ru',
       
    'clientOptions' => [
//        'selector'=> "textarea",  // change this value according to your HTML
//        'plugins'=> "codesample",
//        'toolbar'=> "codesample",
        
//        'theme' => "advanced",
        
        //set br for enter
        'force_br_newlines' => true,
        'force_p_newlines' => false,
        'forced_root_block' => '',
        
    //    
        'file_picker_callback' => new JsExpression("function(cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    
    // Note: In modern browsers input[type=\"file\"] is functional without 
    // even adding it to the DOM, but that might not be the case in some older
    // or quirky browsers like IE, so you might want to add it to the DOM
    // just in case, and visually hide it. And do not forget do remove it
    // once you do not need it anymore.

    input.onchange = function() {
      var file = this.files[0];
      
      var reader = new FileReader();
      reader.onload = function () {
        // Note: Now we need to register the blob in TinyMCEs image blob
        // registry. In the next release this part hopefully won't be
        // necessary, as we are looking to handle it internally.
        var id = 'blobid' + (new Date()).getTime();
        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
        var base64 = reader.result.split(',')[1];
        var blobInfo = blobCache.create(id, file, base64);
        blobCache.add(blobInfo);

        // call the callback and populate the Title field with the file name
        cb(blobInfo.blobUri(), { title: file.name });
      };
      reader.readAsDataURL(file);
    };
    
    input.click();
  }"),
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste image imagetools"
        ],
        
        'menubar'=> ["insert"],
        'automatic_uploads' => true,
        'file_picker_types'=> 'image',
        
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image imageupload | fontselect | cut copy paste"
    ]
]); ?>

    <?php //echo $form->field($model, 'faceImg')->textInput(['maxlength' => true]) ?>
    
    <?php echo $form->field($model, 'file')
                ->fileInput()
                ->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions'=>[
                            'allowedFileExtensions'=>['jpg','gif','png'],
                            'showUpload' => false,
                            'dropZoneEnabled' => false,
                            'initialPreview'=> $model->isNewRecord ? false :
                                [
                                    Html::img("@img-web-blog-posts/{$model->id}/middle/{$model->faceImg}", ['style'=>'width: 100%; height: auto;', 'alt'=>'нет изображения', 'title'=>$model->faceImgAlt]),//картинка ,которая уже загружена у обновляемой записи
                                ],
                            'maxFileSize'=>4000,
                            'minImageWidth'=> 1000,
                            'minImageHeight'=> 700,
                        ],
                                                ]);


    ?>

    <?= $form->field($model, 'faceImgAlt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flagActive')->dropDownList(
                    BlogArticles::$statusesName, 
                    ['prompt'=>'Назначить статус']); ?>

    <?php //echo $form->field($model, 'createdAt')->textInput() ?>

    <?php //echo $form->field($model, 'updatedAt')->textInput() ?>

    <?php //echo $form->field($model, 'createdBy')->textInput() ?>

    <?php //echo $form->field($model, 'updatedBy')->textInput() ?>

    <?php //echo $form->field($model, 'viewCount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/admin', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
