<?php
namespace common\widgets\listLinks;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;


/**
 * Виджет 
 */

class ListLinksWidget extends Widget
{

    public $list = [];

    public function init()
    {
        parent::init();

        if ($this->list == null) {
            throw new InvalidConfigException('In :'.__CLASS__.' Not set or not array: $list' );
        }
        
    }

    public function run()
    {
        return $this->render('index', [
            'list' => $this->list
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