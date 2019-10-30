<?php

/**
 * @package myblog
 * @file SideBarComponent.php created 27.02.2018 14:32:57
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */

namespace frontend\fragments;

use yii\base\Component;
use yii\helpers\Html;
use frontend\services\fragments\SideBarService;

/**
 * \Yii::$app->sidebar->go(); 
 */
class SideBarComponent extends Component{
    
    public $sideBarService;


//    public $temp; //base in config file main
//    
//    const BASE_TEMP = 'base';
    
    public function __construct(SideBarService $sideBarService, $config = [])
    {
        parent::__construct($config);
        $this->sideBarService = $sideBarService;
    }
    
    public function init(){ 
        parent::init();
//        $this->content= 'Текст по умолчанию';
    }
    
//    public function show(){ 
//        
//        switch ($this->temp){
//            case self::BASE_TEMP : 
//                $this->baseTemp();
//                break;
//        }
//        
//    }
//    
//    protected function baseTemp(){
//        return $this->render('//layouts/base/components/_sidebar');
//    }
    
    public function getCategoriesDataSidebar(){
        $cats = $this->sideBarService->shapeCategories();
        return $cats;
    }
    
    public function getTagsDataSidebar(){
        $tags = $this->sideBarService->shapeTags();
        return $tags;
    }
    
    
    
    public function getBestBlogMaterialsSidebar($maxSize = 8){
        $mat = $this->sideBarService->shapeBestBlogMaterials($maxSize);
        return $mat;
    }
    
    public function getRelativeArticlesBySeryToWidget($seryId){
        $obj = $this->sideBarService->shapeArticlesBySeryToWidget($seryId);
        
        return $obj;
    }
    
}
