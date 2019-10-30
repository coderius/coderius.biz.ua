<?php

/**
 * @package myblog
 * @file NavigationComponent.php created 04.03.2018 15:13:34
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */

namespace frontend\fragments;

use yii\base\Component;
use yii\helpers\Html;
use frontend\services\fragments\HeaderService;
use yii\helpers\Url;


class HeaderComponent extends Component{
    
    public $navigationService;
    
    
    public function __construct(HeaderService $navigationService, $config = [])
    {
        parent::__construct($config);
        $this->navigationService = $navigationService;
    }
    
    public function init(){ 
        parent::init();
//        $this->content= 'Текст по умолчанию';
    }
    
    public function getTopNav(){
        return $this->navigationService->shapeTopMeny();
    }
    
    public function isCurrentUrl($url){
        return $url === Url::to('') ? true : false;
    }
    
    
    
}
