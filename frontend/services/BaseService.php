<?php

/**
 * @package myblog
 * @file baseService.php created 13.03.2018 22:44:14
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */
namespace frontend\services;

use yii\helpers\Html;
use yii\helpers\Url;

class BaseService{
    
    /**
     * 
     * @param type $totalCount
     * @param type $pageParam
     * @param type $pageSize
     * @return array
     */
    public static function confLinkPager($totalCount, $pageParam, $pageSize){
        $confPagination = [
                'totalCount' => $totalCount,//количество страниц
                'pageSize' => $pageSize,//кол-во материалов на странице
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageParam' => $pageParam,
                
                ];
        
        $confLinkPager = [
                'pagination' => new \yii\data\Pagination($confPagination),
                'hideOnSinglePage' => true,
                'maxButtonCount' => 6,
                'firstPageLabel' => 'Вначало',
                'lastPageLabel' => 'Вконец',
                'options' => ['class' => 'pagination'],
                'pageCssClass' => 'pagination-row',
                'prevPageCssClass' => 'pagination-row prev',
                'nextPageCssClass' => 'pagination-row next',
                'lastPageCssClass' => 'pagination-row last',
                'activePageCssClass' => 'pagination-row--active',
                'linkOptions' => ['class'=> 'pagination-row-num'],
            ];
        
        
            return $confLinkPager;
    }
    

    
    
    
}