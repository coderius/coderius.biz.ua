<?php
namespace frontend\controllers;

use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\fragments\SearchingSiteModel;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use frontend\models\blog\articles\BlogArticles;
use frontend\models\blog\categories\BlogCategories;
use frontend\models\blog\tags\BlogTags;
use frontend\models\blog\series\BlogSeries;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    
//    public function behaviors()
//    {
//        return [
//            [
//                'class' => 'yii\filters\HttpCache',
//                'only' => ['index'],
//                'lastModified' => function ($action, $params) {
//                    $q = new \yii\db\Query();
//                    $timestamp = strtotime($q->from('blogArticles')->max('updatedAt'));
//                    return $timestamp;
//                },
////                'etagSeed' => function ($action, $params) {
////                    return serialize('12345');
////                }        
//            ],
//                     
//        ];
//    }
    
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = '@app/views/layouts/base/home';
        
        $newArticles = BlogArticles::find()->active()->startNewAreticles()->limit(20);
//        var_dump($na);die;
        $allArticlesCount = BlogArticles::find()->active()->count();
//        var_dump($newArticles->limit(2)->all());
//        var_dump($newArticles->limit(2)->offset(2)->all());die;
        
        \Yii::$app->seo->putSeoTags([
            'title' => \Yii::$app->params['siteSlogan'],
            'description' => "Сайт веб программиста (php, yii2, laravel, javascript, bootstrap). Создание сайтов и программ для веб любой сложности. Консультации и уроки по web программированию.",
            'keywords' => "php yii2 bootstrap",
            'canonical' => Url::canonical(),
        ]);
        
        
        $cloneArt = clone $newArticles;
        $countArt = $cloneArt ->count();
        
        return $this->render('index',[
                    'newArticles' => $newArticles,
                    'allArticlesCount' => $allArticlesCount
                ]);
    }

    
    
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->view->title = Html::encode("Вход на сайт.");
        
        \Yii::$app->seo->putSeoTags([
            'title' => Html::encode("Вход на сайт."),
            'description' => "Сайт веб программиста-" . Html::encode("Вход на сайт."),
            'keywords' => "php yii2 js",
            'canonical' => Url::canonical(),
        ]);
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        \Yii::$app->seo->putSeoTags([
            'title' => Html::encode("Регистрация на сайте."),
            'description' => "Сайт веб программиста-" . Html::encode("Регистрация на сайте."),
            'keywords' => "php yii2 js",
            'canonical' => Url::canonical(),
        ]);
        
        $this->view->title = Html::encode("Регистрация на сайте.");
        
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
