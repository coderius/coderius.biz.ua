<?php
namespace modules\likes\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidArgumentException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use modules\likes\models\Likes;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/**
 * Виджет 
 */

class likeBtnWidget extends Widget
{
    
    public $widgetId;
    public $subjName;
    public $subjMterialId;
    public $class = 'js-rating';
    public $like = 0;
    public $dislike = 0;

    public $messageOptions = [];





    /*
     * Есть ли у текущего пользователя активный лайк
     */
    public $hasActiveLike = false;
    
    /*
     * Есть ли у текущего пользователя активный дизлайк
     */
    public $hasActiveDislike = false;
    
    public function init()
    {
        parent::init();
        
        $this->widgetId = $this->getId();
        
        $this->messageOptions = ArrayHelper::merge($this->defaultMessageOptions(), $this->messageOptions);
        
        if ($this->subjName == null) {
            throw new InvalidConfigException('In :'.__CLASS__.' Not set or not array: $subjName' );
        }
        
        if ($this->subjMterialId == null) {
            throw new InvalidConfigException('In :'.__CLASS__.' Not set or not array: $subjMterialId' );
        }
        
        
        /*
         * Кол-во лайков и дизлайков
         */
        $this->like = Likes::getLikes($this->subjName, $this->subjMterialId);
        $this->dislike = Likes::getDislikes($this->subjName, $this->subjMterialId);
        
        $likesModel = \Yii::createObject([
                    'class' => Likes::className(), 
                    'subject_name' => $this->subjName,
                    'subject_id' => $this->subjMterialId,
                ]);
//        var_dump($likesModel);
        $this->hasActiveLike = $likesModel->hasLike();
        $this->hasActiveDislike = $likesModel->hasDislike();
        


        
    }
    
    
//?netbeanse-xdebug
    public function run()
    {
        parent::run();
        
        $this->makeModal();
        
        $this->registerAssets();

       
        
        echo Html::tag('div', $content = '', $options = [
                'class' => $this->class, 
                'data-like' => $this->like,
                'data-dislike' => $this->dislike,
            ]);
        
    }

   
    protected function defaultMessageOptions(){
         
        return[
            
            'messageToGuest'=> [
                'header' => 'Сообщение для Вас!',
                'message' => 'Для того, чтобы поставить лайк, нужно войти на сайт.'
            ],
            'messageToLike' => [
                'header' => 'Лайк!',
                'message' => 'Вы поставили лайк...'
            ],
            'messageToDislike' => [
                'header' => 'Дизлайк!',
                'message' => 'Вы поставили дизлайк...'
            ],
            'messageToRemoveLike' => [
                'header' => 'Лайк отменен!',
                'message' => 'Вы сняли лайк...'
            ],
            'messageToRemoveDislike' => [
                'header' => 'Дизлайк отменен!',
                'message' => 'Вы сняли дизлайк...'
            ],
        ];
        
    }


    /**
     * Register assets.
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        likeBtnAsset::register($view);
        
        $urlLike = Url::to(['likes/ajax-like']);
        $urlDislike = Url::to(['likes/ajax-dislike']);
        
        $csrf_param = \Yii::$app->request->csrfParam;
        $csrf_token = \Yii::$app->request->csrfToken;
        
        $js = <<<JS
        
        var sendData = {
                '$csrf_param': '$csrf_token',
                'subjName': '$this->subjName',
                'subjMterialId': '$this->subjMterialId',
            };        
                
        $(".{$this->class}").thumbs({
            like: '$this->like',
            dislike: '$this->dislike',
            isActiveLike: '$this->hasActiveLike',
            isActiveDislike: '$this->hasActiveDislike',
            onLike: function (value, self, methods) {
                $.ajax({
                    'type' : 'POST',
                    'url' : '$urlLike',
                    'dataType' : 'json',
                    'data' : sendData,

                    'success' : function(data){
                        
                        if(data.isGuest){
                            console.log(data.isGuest);
                            makeModalText.call(myModalLikesData, '{$this->messageOptions['messageToGuest']['header']}', '{$this->messageOptions['messageToGuest']['message']}');
                        }else{
                
                            //устанавливаем цифры
                            $(self).thumbs('setLike',data.likes);
                            $(self).thumbs('setDislike',data.dislikes);
                            console.log(data.activeControll);
                            //устанавливаем стиль кнопки

                            if(data.activeControll == 'like'){
                                $(self).thumbs('switchToActiveLike');
                                makeModalText.call(myModalLikesData, '{$this->messageOptions['messageToLike']['header']}', '{$this->messageOptions['messageToLike']['message']}');
                            }else{
                                $(self).thumbs('removeActiveLike');
                                makeModalText.call(myModalLikesData, '{$this->messageOptions['messageToRemoveLike']['header']}', '{$this->messageOptions['messageToRemoveLike']['message']}');
                            }
                            
                        }
                        
                    },
                    'error' : function(request, status, error){
                            console.log('ошибка');
                            console.log(status);
                            console.log(error);
                    }
                });
            },
            onDislike: function(value, self, methods) {
               $.ajax({
                    'type' : 'POST',
                    'url' : '$urlDislike',
                    'dataType' : 'json',
                    'data' : sendData,

                    'success' : function(data){
                        if(data.isGuest){
                            console.log(data.isGuest);
                            makeModalText.call(myModalLikesData, '{$this->messageOptions['messageToGuest']['header']}', '{$this->messageOptions['messageToGuest']['message']}');            
                        }else{
                            $(self).thumbs('setLike',data.likes);
                            $(self).thumbs('setDislike',data.dislikes);
                            console.log(data.activeControll);
                            //устанавливаем стиль кнопки
                            if(data.activeControll == 'dislike'){
                                $(self).thumbs('switchToActiveDislike');
                                makeModalText.call(myModalLikesData, '{$this->messageOptions['messageToDislike']['header']}', '{$this->messageOptions['messageToDislike']['message']}');
                            }else{
                                $(self).thumbs('removeActiveDislike');
                                makeModalText.call(myModalLikesData, '{$this->messageOptions['messageToRemoveDislike']['header']}', '{$this->messageOptions['messageToRemoveDislike']['message']}');
                            }
                        }
                
                    },
                    'error' : function(request, status, error){
                            console.log('ошибка');
                            console.log(status);
                            console.log(error);
                    }
                });
            }
        });        



        
JS;

        $view->registerJs($js, \yii\web\View::POS_READY);
        
    }
    
    protected function makeModal()
    {
        Modal::begin([
            'header' => '<h2>Сообщение</h2>',
            'options' => [
                'id' => $this->widgetId."_modal",
                ],
            'size' => Modal::SIZE_LARGE,
        ]);

        echo \Yii::t('yii', 'Load...');

        Modal::end();
        
        $this->registerAssetsModal();
    }
    
    protected function registerAssetsModal()
    {
        $view = $this->getView();
        $css = <<< CSS
            .modal-backdrop {
                z-index: 1040 !important;
            }
                
            .modal-dialog {
                margin: 2px auto;
                z-index: 1100 !important;
            }    

CSS;
        $view->registerCss($css, ["type" => "text/css"], "myStyles" );
        
    
        
        $js = <<<JS
            
            
            var myModalLikesData = {
                myModalLikes : $('#{$this->widgetId}_modal'),
                modalBody :    $('#{$this->widgetId}_modal').find('.modal-body'),
                modalTitle :   $('#{$this->widgetId}_modal').find('.modal-header')
            };
            
            function makeModalText(title, text){
                console.log(this);
                this.myModalLikes.modal('show');
                this.myModalLikes.appendTo("body");
                
                this.modalTitle.find('h2').html(title);
                this.modalBody.html(text);
            
            }
JS;
        $view->registerJs($js, \yii\web\View::POS_READY);
    }




}