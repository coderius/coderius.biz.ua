<?php
namespace common\widgets\sidebar\bestMaterials;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;


/**
 * Виджет 
 */

class BestMaterialsSideBarWidget extends Widget
{

    public $title = [];
    public $list = [];
    
    public function init()
    {
        parent::init();

        if (!is_array($this->list) || $this->list == null) {
            throw new InvalidConfigException('In :'.__CLASS__.' Not set or not array: $list' );
        }
        
    }

    public function run()
    {
        return $this->render('index', [
            'title' => $this->title,
            'list' => $this->list,
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