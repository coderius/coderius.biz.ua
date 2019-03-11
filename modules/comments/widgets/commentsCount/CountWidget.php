<?php
namespace modules\comments\widgets\commentsCount;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidArgumentException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
//use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use modules\comments\Module;
use modules\comments\traits\TranslationsTrait;
use yii\helpers\Json;

/**
 * Виджет 
 */

class CountWidget extends Widget
{
    use TranslationsTrait;
    
    public $materialAuthorId = false;
    
    public $emptyText;
    
    public $widgetId;
    
    public $condition;
    
    protected $encryptedEntity;

    public function init()
    {
        parent::init();
        $this->registerTranslations();
        
        if ($this->condition === null) {
            throw new InvalidConfigException('In :'.__CLASS__.' Not set param "condition"' );
        }
        
        if ($this->emptyText === null) {
            $this->emptyText = 0;
        }
        
        $this->widgetId = "countComment_" . $this->getId();
        
        
    }
    
    
//?netbeanse-xdebug
    public function run()
    {
        parent::run();
        
        $CommentsSearch = Module::instance()->model('CommentsSearch');
//        $commentsModel = $commentsClass::getTree($this->entity, $this->entityId, $this->maxLevel);
        
        $searchModel = new $CommentsSearch;
        $dataProvider = $searchModel->search($this->condition);
        $dataProvider->pagination = false;
//        var_dump($dataProvider->getTotalCount()); die;
        return $dataProvider->getCount() ? : $this->emptyText;
        
        
    }

    
    
    
    
   




}