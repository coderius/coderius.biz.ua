<?php

/**
 * @package myblog
 * @file SitemapController.php created 10.04.2018 12:11:48
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */
namespace frontend\controllers;
 
use frontend\models\blog\articles\BlogArticles;
use frontend\models\blog\categories\BlogCategories;
use frontend\models\blog\series\BlogSeries;
use frontend\models\blog\tags\BlogTags;
use yii\web\Controller;
use yii\db\Query;
use Yii;

class SitemapController extends Controller
{
 
    public function actionIndex()
    {
//        Yii::$app->cache->delete('sitemap');
        
        if (!$xml_sitemap = Yii::$app->cache->get('sitemap')) {  // проверяем есть ли закэшированная версия sitemap
        $urls = array();
 
            // Выбираем категории сайта
            $articles = BlogArticles::find()->active()->orderCreatedAt()->all();
            foreach ($articles as $article) {
                $urls[] = array(
                    'loc' => $article->url,
                    'lastmod' => date( DATE_W3C, strtotime($article->lastMod) ),
                    'changefreq' => 'daily',
                    'priority' => 1.0
                );
            }
 
            
            $categories = BlogCategories::find()->orderId()->all();
            foreach ($categories as $category) {
                $urls[] = array(
                    'loc' => $category->url,
                    'changefreq' => 'weekly',
                    'priority' => 0.8
                );
            }
            
            $series = BlogSeries::find()->orderId()->all();
            foreach ($series as $sery) {
                $urls[] = array(
                    'loc' => $sery->url,
                    'changefreq' => 'weekly',
                    'priority' => 0.5
                );
            }
            
            $tags = BlogTags::find()->orderId()->all();
            foreach ($tags as $tag) {
                $urls[] = array(
                    'loc' => $tag->url,
                    'changefreq' => 'weekly',
                    'priority' => 0.4
                );
            }
            
//            var_dump($urls);die;
            
            $xml_sitemap = $this->renderPartial('index', array( // записываем view на переменную для последующего кэширования
                'host' => Yii::$app->request->hostInfo,         // текущий домен сайта
                'urls' => $urls,                                // с генерированные ссылки для sitemap
            ));
        
            Yii::$app->cache->set('sitemap', $xml_sitemap, 60*60*12); // кэшируем результат на 12 ч
    }
    
//        Yii::$app->response->format = \yii\web\Response::FORMAT_XML; // устанавливаем формат отдачи контента
    
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
    
        return $xml_sitemap;
    }
    
    
}

