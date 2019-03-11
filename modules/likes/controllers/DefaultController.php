<?php
namespace modules\likes\controllers;
/**
 * @package myblog
 * @file DefaultController.php created 28.05.2018 20:30:44
 * 
 * @copyright Copyright (C) 2018 Sergio coderius <coderius>
 * @license This program is free software: GNU General Public License
 */
use yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use modules\likes\models\Likes;

/**
 * Default controller for the `likes` module
 */
class DefaultController extends Controller
{
    public $messageToGuest = 'Для голосования нужно зарегестрироваться или войти на сайт.';

    //Будет ли лайк или дизлайк активным, чтобы присвоить соответствующий css класс
    public $activeControll = 'not';
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return "";
    }
    
    public function actionAjaxLike()
    {
        $request = Yii::$app->request;
        
        if ($request->isPost) {
            
            if(\Yii::$app->user->isGuest){
                $result =  ['isGuest' => true];
            }else{
                $subjName = $request->post('subjName');
                $subjMterialId = $request->post('subjMterialId');

                $likes = new Likes([
                            'subject_name' => $subjName,
                            'subject_id' => $subjMterialId,
                        ]);

                if($likes->hasLike()){//есть ли лайк
                    $likes->unsetLikes();//снимаем его
                }else{
                    $likes->setLikes();//устанавливаем лайк
                    $this->activeControll = Likes::ACTION_LIKE;//для назначения стилей
                }

                $result = [
                        'likes' => Likes::getLikes($subjName, $subjMterialId),
                        'dislikes' => Likes::getDislikes($subjName, $subjMterialId),
                        'activeControll' => $this->activeControll
                    ];
            }
            

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $result;
            
        } else {
//            throw new BadRequestHttpException('Only POST is allowed');//не нравится гуглу
            return null;
        }

    }
    
    public function actionAjaxDislike()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            
            if(\Yii::$app->user->isGuest){
                $result =  ['isGuest' => true];
            }else{
                $subjName = $request->post('subjName');
                $subjMterialId = $request->post('subjMterialId');

                $likes = new Likes([
                            'subject_name' => $subjName,
                            'subject_id' => $subjMterialId,
                        ]);

                if($likes->hasDislike()){
                    $likes->unsetDislikes();

                }else{
                    $likes->setDislikes();
                    $this->activeControll = Likes::ACTION_DISLIKE;//для назначения стилей

                }

                $result = [
                        'likes' => Likes::getLikes($subjName, $subjMterialId),
                        'dislikes' => Likes::getDislikes($subjName, $subjMterialId),
                        'activeControll' => $this->activeControll
                    ];
            }
            
           
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $result;
            
        } else {
//            throw new BadRequestHttpException('Only POST is allowed');//не нравится гуглу
            return null;
        }

    }
    
}