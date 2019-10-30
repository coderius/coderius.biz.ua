<?php

/**
 * @package myblog
 * @file NavigationComponent.php created 04.03.2018 15:13:34
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */

namespace frontend\fragments;

use yii;
use yii\base\Component;
use yii\helpers\Html;
use frontend\services\fragments\HeaderService;
use yii\helpers\Url;


class SeoComponent extends Component{
    
    public $currentFacebookOgUrl = null;


    public function __construct($config = [])
    {
        parent::__construct($config);
        
    }
    
    public function init(){ 
        parent::init();
//        $this->content= 'Текст по умолчанию';
    }
    
    public function putSeoTags($tags){
        if( isset($tags['title']) ){
            \Yii::$app->view->title = $tags['title'];
        }
        
        if( isset($tags['description']) ){
            \Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $tags['description'],
            ], 'description');
        }
        
        if( isset($tags['keywords']) ){
            \Yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $tags['keywords'],
            ], 'keywords');
        }
        
        if( isset($tags['canonical']) ){
            \Yii::$app->view->registerLinkTag([ 'rel' => 'canonical', 'href' => $tags['canonical'] ]);
        }
        
    }
    
    public function putFacebookMetaTags($tags){
        
        foreach($tags as $prop => $content){
            \Yii::$app->view->registerMetaTag([
                'property' => $prop,
                'content' => $content,
            ], $prop);
        }
    }
    
    public function putTwitterMetaTags($tags){
        
        foreach($tags as $name => $content){
            \Yii::$app->view->registerMetaTag([
                'name' => $name,
                'content' => $content,
            ], $name);
        }
    }
    
    public function putGooglePlusMetaTags($tags){
        
        foreach($tags as $itemprop => $content){
            \Yii::$app->view->registerMetaTag([
                'itemprop' => $itemprop,
                'content' => $content,
            ], $itemprop);
        }
    }
    
    
    
    public function getCurrentFacebookOgUrl(){
        if(null === $this->currentFacebookOgUrl){
            $this->currentFacebookOgUrl = Url::canonical();
        }
        
        return $this->currentFacebookOgUrl;
    }
    
}
