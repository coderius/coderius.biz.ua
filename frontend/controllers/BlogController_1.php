<?php
namespace frontend\controllers;

use frontend\services\blog\BlogService;
use yii\helpers\Html;
use yii\helpers\Url;

class BlogController extends BaseController
{
    const SECTION_NAME = 'Блог';
    
    private $blogService;
    
    public $pageSize = 15;


    public function __construct($id, $module, BlogService $blogService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->blogService = $blogService;
    }
    
    public function beforeAction($action) {
        if ($action->id !== 'index'){
            //ссылка на блог в хлебных крошках
            $this->view->params['breadcrumbs'][] = array('label'=> self::SECTION_NAME, 'url'=> Url::toRoute('/blog'));
        }else{
            $this->view->params['breadcrumbs'][] = Html::encode(self::SECTION_NAME);
            $this->view->title = Html::encode(self::SECTION_NAME) . ": все посты";
        }
        return parent::beforeAction($action);
    }

    public function actionIndex($pageNum = null)
    {
        $result = $this->blogService->getBlog($pageNum, $this->pageSize);
        
        list($arrayDtoArticle, $arrayDtoCategory, $arrayDtoTagInArticle, $arrayViewsSubjects, $arrayDtoSery, $confLinkPager) = $result;
//        var_dump($arrayViewsSubjects);die;
        return $this->render('index',compact(
                'arrayDtoArticle',
                'arrayDtoCategory',
                'arrayDtoTagInArticle',
                'arrayViewsSubjects',
                'arrayDtoSery',
                'confLinkPager'
                ));
    }
    
    public function actionCategory($alias, $pageNum = null)
    {
        $result = $this->blogService->getCategory($alias, $pageNum, $this->pageSize);
        
        list($arrayDtoArticle, $arrayDtoCategory, $arrayDtoTagInArticle, $arrayDtoSery, $dtoCategory, $confLinkPager) = $result;
        
        return $this->render('category',compact(
                'arrayDtoArticle',
                'arrayDtoCategory',
                'arrayDtoTagInArticle',
                'arrayDtoSery',
                'dtoCategory',
                'confLinkPager'
                ));
    }
    
    public function actionSery($alias, $pageNum = null)
    {
        
        $result = $this->blogService->getSery($alias, $pageNum, $this->pageSize);
        
        list($arrayDtoArticle, $arrayDtoCategory, $arrayDtoTagInArticle, $arrayDtoSery, $dtoSery, $confLinkPager) = $result;
        
        return $this->render('sery',compact(
                'arrayDtoArticle',
                'arrayDtoCategory',
                'arrayDtoTagInArticle',
                'arrayDtoSery',
                'dtoSery',
                'confLinkPager'
                ));
    }
    
    public function actionTag($alias, $pageNum = null)
    {
        $result = $this->blogService->getByTag($alias, $pageNum, $this->pageSize);
        
        list($arrayDtoArticle, $arrayDtoCategory, $arrayDtoTagInArticle, $arrayDtoSery, $dtoTag, $confLinkPager) = $result;
        
        return $this->render('tag',compact(
                'arrayDtoArticle',
                'arrayDtoCategory',
                'arrayDtoTagInArticle',
                'arrayDtoSery',
                'dtoTag',
                'confLinkPager'
                ));
    }
    
    public function actionArticle($alias)
    {
        
        $result = $this->blogService->getArticle($alias);
//        var_dump($arrayDtoArticlesInSery);die;
        list($dtoArticle, $dtoCategory, $arrayArticlesInSeryWidget) = $result;
//        var_dump($arrayDtoArticlesInSery);die;
        return $this->render('article',compact(
                'dtoArticle',
                'dtoCategory',
                'arrayArticlesInSeryWidget'
                ));
    }
    
}

