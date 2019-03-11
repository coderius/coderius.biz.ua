<?php

/**
 * @package myblog
 * @file SearchController.php created 08.03.2018 21:09:57
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */
namespace frontend\controllers;

use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use frontend\models\search\SearchingSiteModel;
use \frontend\services\BaseService;
use yii\helpers\HtmlPurifier;

class SearchController extends BaseController
{
    public $pageSize = 15;
    


    public function actionIndex($pageNum = null)
    {
        
//        var_dump(Yii::$app->request->queryParams['q']);die;
        $searchModel = new SearchingSiteModel();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $q = $searchModel->q;
//        var_dump($dataProvider);
        $confLinkPager = BaseService::confLinkPager($dataProvider->getTotalCount(), 'pageNum', $this->pageSize);
        $dataProvider->pagination = $confLinkPager['pagination'];
//        var_dump(static::$decoded);die;
        if($pageNum > $dataProvider->pagination->pageCount)
        {
            throw new \yii\web\HttpException(404, 'Такой страницы не существует. ');
        }
        
        if($pageNum == 1)
        {
            $this->redirect(Url::toRoute(['/search?q='. $q]));
        }
        
        //Meta tags
        \Yii::$app->seo->putSeoTags([
            'title' => "Ищем: " . $q,
            'description' => "Результаты поиска по сайту по фразе - " . $q,
            'keywords' => "программирование development php yii2",
//            'canonical' => Url::canonical(),
        ]);
        
        $this->view->params['breadcrumbs'][] = "Поиск: \"".$q."\"". ($pageNum ? " -стр.{$pageNum}" : '');
        
        $searchWords = $searchModel->searchWords;
        $countResults = $searchModel->countResults;
//        var_dump($q);
        return $this->render('index',compact(
                                            'dataProvider',
                                            'confLinkPager',
                                            'pageNum',
                                            'q',
                                            'searchWords',
                                            'countResults'
                                            )
                     
                );
    }
}
