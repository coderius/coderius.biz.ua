<?php
namespace common\widgets\viewBlocks\middleColumnPics;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;


/**
 * Виджет 
 */

class MiddleColumnPicsWidget extends Widget
{

    public $model;
    public $header;
    public $button;
    public $section_separator_top;
    public $section_separator_bottom;
    
//    public $model;

    public function init()
    {
        parent::init();

        if ($this->model == null) {
            throw new InvalidConfigException('In :'.__CLASS__.' Not set $this->model' );
        }
        
//        $class = \frontend\models\blog\articles\BlogArticles::className();
//        if (!($this->model instanceof $class) ) {
//            var_dump($this->model);die;
//        }
       
    }

    public function run()
    {
        return $this->render('index', [
            'model' => $this->model,
            'header' => $this->header,
            'button' => $this->button,
            'section_separator_top' => $this->section_separator_top,
            'section_separator_bottom' => $this->section_separator_bottom,
        ]);

    }

    /**
     * Register assets.
     */
    protected function registerAssets()
    {
        $view = $this->getView();
    }




}