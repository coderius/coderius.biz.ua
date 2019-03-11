<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;


class BaseController extends Controller
{
    // по умолчанию для всего сайта
    public $layout = '@app/views/layouts/base/main';
    
    
    public function init() {
        
        //$ip = Yii::$app->geoip->ip(Yii::$app->request->userIP);
        
        //if($ip->hasResult()){
        //    Yii::$app->setTimeZone($ip->location->timeZone);
        //}
        //else{
        //    Yii::$app->setTimeZone('Europe/Kiev');
        //}
        
        
        parent::init();
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
//                    [
//                        
//                        'allow' => true,
//                        'roles' => [\common\components\rbac\Rbac::PERMISSION_ADMIN_PANEL],
//                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],

        ];
    }
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
//        $ip = Yii::$app->request->userIP;
//        
//        $ip = Yii::$app->geoip->ip("208.113.83.165", false);
//        var_dump($ip->city);
//        var_dump($ip->continent);
//        var_dump($ip->country);
//        var_dump($ip->location);
//        var_dump($ip->postal);
//        var_dump($ip->registeredCountry);
//        var_dump($ip->subdivisions);
//        var_dump(Yii::$app->formatter->timeZone);
        
//        $ip = Yii::$app->geoip->ip(Yii::$app->request->userIP);
//        
//        var_dump($ip);
        return parent::beforeAction($action);
    }
    
    
}

