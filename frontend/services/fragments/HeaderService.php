<?php

/**
 * @package myblog
 * @file NavigationService.php created 04.03.2018 15:20:09
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */
namespace frontend\services\fragments;

use frontend\repositories\blog\BlogRepositoryInterface;
use frontend\models\fragments\NavigationTop;

class HeaderService{
    private $blogRepository;


    public function __construct(BlogRepositoryInterface $blogRepository) {
        $this->blogRepository = $blogRepository;
    }
    
    public function shapeTopMeny(){
        $items = NavigationTop::getTree();
         
//        var_dump(NavigationTop::getTree());die;
        
        return $items;
    }
    
    
    
}