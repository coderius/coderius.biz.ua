<?php

/**
 * @package myblog
 * @file RssController.php created 28.07.2018 13:40:00
 * 
 * @copyright Copyright (C) 2018 Sergio coderius <coderius>
 * @license This program is free software: GNU General Public License
 */
namespace frontend\controllers;
 
use frontend\models\blog\articles\BlogArticles;
use frontend\models\blog\categories\BlogCategories;
use frontend\models\blog\series\BlogSeries;
use frontend\models\blog\tags\BlogTags;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use Yii;

class RssController extends Controller
{
   
    /**
     * @var array
     */
    public $requiredChannelElements = ['title', 'link', 'description'];
    /**
     * @var array
     */
    public $requiredItemElements = ['title', 'description', 'link', 'pubDate'];
    
    public function actionIndex()
    {
        Yii::$app->cache->delete('rss-feed');
        
        if (!$rss_feed = Yii::$app->cache->get('rss-feed')) { 
            $channel = $this->makeChannelInfo();
            
            $items = $this->makeItemsInfo();
            
            $rss_feed = $this->renderPartial('index', compact('channel', 'items'));
        
            Yii::$app->cache->set('rss-feed', $rss_feed, 60*60*12); // кэшируем результат на 12 ч
        }
    
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->set('Content-Type', 'application/rss+xml; charset=utf-8');
    
        return $rss_feed;
    }
    
    private function makeChannelInfo(){
        $channel = [
            'atom:link' => Url::toRoute(['/rss.xml'], 'https'),
            'title' => Yii::$app->params['siteSlogan'].' | '.\Yii::$app->name,
            'link' => Url::base('https'),
            'description' => Yii::$app->params['siteDescription'],
            'language' => Yii::$app->language,
            'image'=> $this->addChannelImage(),
        ];
//        var_dump(array_diff_key(array_flip($this->requiredChannelElements), $channel));die;
        
        $dif = $this->array_values_keys_dif($this->requiredChannelElements , $channel);
        if (!empty($dif)) {
                throw new InvalidConfigException('Required channel attributes: "'.implode(" ,",array_flip($dif)).'" must be set');
        }
        
        return $channel;
    }
    
    private function makeItemsInfo(){
        $items = array();
 
        $dataProvider = new ActiveDataProvider([
            'query' => BlogArticles::find()->active()->orderCreatedAt(),
            'pagination' => [
                'pageSize' => 10
            ],
        ]);
        
        if ($dataProvider->getCount() == 0) {
            return false;
        }
        
        $articles = $dataProvider->getModels();
        
        foreach ($articles as $k => $article) {
            $items[$k] = array(
                'title' => $article->metaTitle,
                'description' => $article->metaDesc,
                'link' => $article->getUrl('https'),
//                'author' => $article->hasAuthor() ? $article->author->email : false,
                'category' => $article->hasCategory() ? $article->category->metaTitle : false,
                'guid' => $article->getUrl('https'),
                'pubDate' => date( DATE_RSS, strtotime($article->lastMod) )
            );
            
            $dif = $this->array_values_keys_dif($this->requiredItemElements , $items[$k]);
            if (!empty($dif)) {
                throw new InvalidConfigException('Required channel attributes: "'.implode(" ,",array_flip($dif)).'" must be set');
            }
            
        }
        
        return $items;
    }
    
    private function addChannelImage(){
        $img = false;
        
        
        return $img;
    }
    /**
     * 
     * @param array $search_values
     * @param array $keys_array
     * @return type array wich dif keys for array $search_values if they are not in the array $keys_array
     */
    private function array_values_keys_dif(array $search_values , array $keys_array) {
        return array_diff_key(array_flip($search_values), $keys_array);
    }
    
}
