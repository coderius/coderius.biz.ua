<?php
namespace modules\comments\controllers;
/**
 * @package myblog
 * @file DefaultController.php created 28.05.2018 20:30:44
 * 
 * @copyright Copyright (C) 2018 Sergio coderius <coderius>
 * @license This program is free software: GNU General Public License
 */
use Yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use modules\comments\models\Comments;
use modules\comments\models\CommentsForm;
use modules\comments\Module;
use yii\helpers\Json;

/**
 * Default controller for the `likes` module
 */
class DefaultController extends Controller
{
    
    /**
     * Renders the index view for the module
     * @return string
     */
//    public function actionCreate($entity)
//    {
//        $request = Yii::$app->request;    
////        if ($request->isPost) {
////           var_dump($request->post());die;
////        }
//        
//        
//        $commentsClass = Module::instance()->model('Comments');
//        $commentModel = Yii::createObject([
//            'class' => $commentsClass,
//        ]);
//        $commentModel->setAttributes($this->getCommentAttributesFromEntity($entity));
//        
////        var_dump($commentModel->load(Yii::$app->request->post(), 'CommentsForm'));die;
//        if ($commentModel->load(Yii::$app->request->post(), 'CommentsForm')) {
//            if(!$commentModel->validate()){
//                throw new \yii\base\Exception($commentModel->errors);
//            }
//            $commentModel->save();
//            return $this->redirect(Yii::$app->request->referrer);
//        }else{
//            
//            throw new \yii\base\Exception('Something wos wrong!');//не нравится гуглу
//            return null;
//        }
//    }
    public function actions()
    {
        return [
            // ...
            'captcha' => [
                'class' => 'modules\comments\components\MathCaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
        ];
    }
   
    protected function getCommentAttributesFromEntity($entity)
    {
        $decryptEntity = Yii::$app->getSecurity()->decryptByKey(utf8_decode($entity), Module::instance()->id);
        if (false !== $decryptEntity) {
            return Json::decode($decryptEntity);
        }
        throw new BadRequestHttpException(Yii::t('comments/messages', 'Oops, something went wrong. Please try again later.'));
    }
    
    public function formValid($post)
    {
        $commentFormClass = Module::instance()->model('CommentsForm');
        
        $commentFormModel = new $commentFormClass(['scenario' => Yii::$app->user->isGuest ? $commentFormClass::SCENARIO_GUEST: $commentFormClass::SCENARIO_USER]);
        if($commentFormModel->load($post) && $commentFormModel->validate()){
            return true;
        }
        
        //если сессия об обновлении есть, удаляем ее и ставим 'captchaRefresh' => true
        $captchaRefresh = false;
        if(Yii::$app->session->has('captchaRefresh')){
            $captchaRefresh = true;
            Yii::$app->session->remove('captchaRefresh');
        }
        
        
        return [
            'status' => 'errorValidate',
            'model' => 'CommentsForm',
            'captchaRefresh' => $captchaRefresh,
            'data' => \Yii::$app->session,//
//            'error' => \yii\widgets\ActiveForm::validate($commentFormModel),//$commentFormModel->getErrors()
            'error' => $commentFormModel->getErrors()
        ];
    }
    
    
    public function actionAjaxCreate($entity)
    {
        $request = Yii::$app->request;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($request->isPost) {
            
            $formValid = $this->formValid(Yii::$app->request->post());
            if(true !== $formValid){
//                
//                $ses = [
//                    'status' => 'errorBySession',
//                    'data' => \Yii::$app->session
//                ];
//                Yii::$app->session->remove('ses5');
//                Yii::$app->session->remove('ses2');
//                Yii::$app->session->remove('ses3');
//                Yii::$app->session->remove('ses4');
//                Yii::$app->session->remove('ses7');
//                return $ses;
                
                return $formValid;
            }
            
            $commentsClass = Module::instance()->model('Comments');
            $commentModel = Yii::createObject([
                'class' => $commentsClass,
            ]);
            $commentModel->setAttributes($this->getCommentAttributesFromEntity($entity));
            
            
            
    //        var_dump($commentModel->load(Yii::$app->request->post(), 'CommentsForm'));die;
            if ($commentModel->load(Yii::$app->request->post(), 'CommentsForm')) {
                if(!$commentModel->validate()){
                    return [
                        'status' => 'errorValidate',
                        'model' => 'Comments',
                        'error' => $commentModel->errors,
                        
                    ];
                }
                $commentModel->save();
                return ['status' => 'success','post' => Yii::$app->request->post()];
            }else{

                return [
                    'status' => 'error',
                    'error' => \Yii::$app->response->data,
                    
                ];
            }
        }
        
    }
    
    public function actionAjaxLike()
    {
        $request = Yii::$app->request;
        
        if ($request->isPost) {
            
            $commentId = $request->post('commentId');
            $commentsClass = Module::instance()->model('Comments');
            $like = $commentsClass::setToggleLike($commentId);
            
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            if(false !== $like){
                return ['like' => $like, 'status' => 'success'];
            }else {
//            throw new BadRequestHttpException('Only POST is allowed');//не нравится гуглу
                return [
                    'status' => 'error',
                    'error' => 'not find',
                ];
            }
        }

    }
    //desibled-comment
    public function actionDesibledComment()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $commentId = $request->post('commentId');
            $commentsClass = Module::instance()->model('Comments');
            $desibled = $commentsClass::markAsDesibled($commentId);
//            var_dump('jj');die;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(false !== $desibled){
                return ['status' => 'success'];
            }else {

                return [
                    'status' => 'error',
                    'error' => 'not done action',
                ];
            }
        }
    }
    
    public function actionActiveComment()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $commentId = $request->post('commentId');
            $commentsClass = Module::instance()->model('Comments');
            $active = $commentsClass::markAsActive($commentId);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(false !== $active){
                return ['status' => 'success'];
            }else {

                return [
                    'status' => 'error',
                    'error' => 'not done action',
                ];
            }
        }
    }
    
    
    
}

