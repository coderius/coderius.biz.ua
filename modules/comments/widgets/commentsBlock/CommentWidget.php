<?php
namespace modules\comments\widgets\commentsBlock;

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

class CommentWidget extends Widget
{
    use TranslationsTrait;
    
    public $title;
    
    public $formTitle;
    
    public $materialAuthorId = false;
    
    public $widgetId;
    
    public $viewFile = 'index';
    
    public $assetDepends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    
    /**
     * @var string comment form id
     */
    public $formId = 'comment-form';

    public $entity;
    
    public $entityId;

    public $maxLevel = 10;

    public $emptyText;
    
    protected $encryptedEntity;

    public function init()
    {
        parent::init();
        $this->registerTranslations();
        
        if ($this->title === null) {
            $this->title = static::t('messages', 'Comments.');
        }
        
        if ($this->formTitle === null) {
            $this->formTitle = static::t('messages', 'Create comment.');
        }
        
        if ($this->emptyText === null) {
            $this->emptyText = static::t('messages', 'No comments yet.');
        }
        
        $this->widgetId = $this->getId();
        
        $this->encryptedEntity = $this->getEncryptedEntity();
        
        $this->registerAssets();
        
    }
    
    
//?netbeanse-xdebug
    public function run()
    {
        parent::run();
        
        $commentsClass = Module::instance()->model('Comments');
        $commentsModel = $commentsClass::getTree($this->entity, $this->entityId, $this->maxLevel);
        
        $commentsProvider = new ArrayDataProvider([
            'allModels' => $commentsModel,
            'pagination' => false,
        ]);
        
        $commentFormClass = Module::instance()->model('CommentsForm');
        
        $commentFormModel = Yii::createObject([
            'class' => $commentFormClass,
            'entity' => $this->entity,
            'entityId' => $this->entityId,
            'scenario' => Yii::$app->user->isGuest ? $commentFormClass::SCENARIO_GUEST: $commentFormClass::SCENARIO_USER
        ]);
        
//        if($commentFormModel->load(Yii::$app->request->post())){
//            \yii\widgets\ActiveForm::validate($commentFormModel);
//        }
        
        
        return $this->render($this->viewFile ,[
            'formId' => $this->formId,
            'commentFormModel' => $commentFormModel,
            'commentsProvider' => $commentsProvider,
            'maxLevel' => $this->maxLevel,
            'emptyText' => $this->emptyText,
            'title' => $this->title,
            'materialAuthorId' => $this->materialAuthorId,
            'encryptedEntity' => $this->encryptedEntity,
            'formTitle' => $this->formTitle,
        ]);
        
        
    }

    
    
    /**
     * Register assets.
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        
        $asset = CommentAsset::register($view);
        
        if($this->assetDepends && !empty($this->assetDepends)){
            if (!is_array($this->assetDepends)) {
                throw new InvalidConfigException('In :'.__CLASS__.' Variable assetDepends must be an array' );
            }
            
            $asset->depends = $this->assetDepends;
            
        }
    }
    
    /**
     * Get encrypted entity
     *
     * @return string
     */
    protected function getEncryptedEntity()
    {
        return utf8_encode(Yii::$app->getSecurity()->encryptByKey(Json::encode([
            'entity' => $this->entity,
            'entityId' => $this->entityId,
        ]), Module::instance()->id));
    }
    
    protected function recaptcha(){
        //секретный ключ
        $secret = "6Lf06GQUAAAAAG4r4bkkQMhowDNZLOv_BCtxemRM";
        //ответ
        $response = null;
        //проверка секретного ключа
        $reCaptcha = new ReCaptcha($secret);

        if (!empty($_POST)) {

            if ($_POST["g-recaptcha-response"]) {
                $response = $reCaptcha->verifyResponse(
                    $_SERVER["REMOTE_ADDR"],
                    $_POST["g-recaptcha-response"]
                );
            }

            if ($response != null && $response->success) {
                return true;
            } else {
                return false;
            }

        }
        
        return false;
    }
    
   




}