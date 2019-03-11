<?php

/**
 * @package myblog
 * @file adminPanel.php created 11.08.2018 17:11:22
 * 
 * @copyright Copyright (C) 2018 Sergio coderius <coderius>
 * @license This program is free software: GNU General Public License
 */

namespace frontend\fragments;

use yii\base\Component;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\repositories\blog\BlogRepositoryInterface;
use frontend\models\blog\articles\BlogArticles;
use common\enum\BlogEnum;

class AdminPanel extends Component{
    
    private $_blogRepository;
    
    public function __construct(BlogRepositoryInterface $blogRepository, $config = []) {
        parent::__construct($config);
        $this->_blogRepository = $blogRepository;
    }
    
    public function init(){ 
        parent::init();
//        $this->content= 'Текст по умолчанию';
    }
    
    public function getBlogArticle($alias){
        return BlogArticles::findArticleByAlias($alias, false);
    }
    
    public function hasErrorException(){
        return Yii::$app->getErrorHandler()->exception === null;
    }
    
}
