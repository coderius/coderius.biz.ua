<?php

namespace backend\models\blog;

use Yii;
use common\components\behaviors\PurifyBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use common\models\user\User;
use yii\helpers\ArrayHelper;
use yii\behaviors\AttributeTypecastBehavior;
use yii\web\JsExpression;

/**
 * This is the model class for table "blogArticles".
 *
 * @property int $id
 * @property int $idCategory
 * @property string $alias
 * @property string $metaTitle
 * @property string $metaDesc
 * @property string $metaKeywords
 * @property string $title
 * @property string $text
 * @property string $faceImg
 * @property string $faceImgAlt
 * @property int $flagActive
 * @property string $createdAt
 * @property string $updatedAt
 * @property int $createdBy
 * @property int $updatedBy
 * @property int $viewCount
 *
 * @property BlogCategories $category
 * @property BlogArticlesBlogSeries[] $blogArticlesBlogSeries
 * @property BlogSeries[] $series
 * @property BlogTagsBlogArticles[] $blogTagsBlogArticles
 * @property BlogTags[] $blogTags
 * @property ViewsStatisticArticles $viewsStatisticArticles
 */
class BlogArticles extends \yii\db\ActiveRecord
{
    public $searchAliasTags;//из таблицы имя алиаса в Search
    public $searchAliasSeries;//из таблицы имя алиаса в Search

    public $selectedCategory;//virtual var use in form create or update
    public $selectedSery = [];//virtual var use in form create or update
    public $selectedTags = [];//virtual var use in form create or update

    public $file;//загружаемое изображение

    
    const ACTIVE_STATUS = 1;
    const DISABLED_STATUS = 0;
    
    public static $statusesName = [
        self::ACTIVE_STATUS => 'Активен',
        self::DISABLED_STATUS => 'Отключен',
        ];
    
    public function init()
    {
        parent::init();
//        var_dump($this);die;
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blogArticles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['selectedCategory', 'metaTitle', 'metaDesc', 'title', 'text', 'faceImgAlt', 'flagActive'], 'required'],
            
//            ['file', 'required','skipOnEmpty' => false, 'when' => function ($model) {
//                if ($model->isNewRecord){
//                    return true;
//                }else{
//                    if($model->faceImg === null){
//                        return true;
//                    }
//                }
//                return false;
//            }, 
////                'whenClient' => new JsExpression("function (attribute, value) {
////                    return value == '';
////                    
////                    
////                }"),
//                    
//                'on' => self::SCENARIO_DEFAULT,  
//            ],
            
            [['selectedCategory', 'flagActive', 'viewCount'], 'integer'],
            [['metaDesc', 'text'], 'string'],
            
//            [['flagActive'], 'in', 'range' => [0,1]],
            
            [['faceImg', 'id', 'metaKeywords', 'createdBy', 'updatedBy','createdAt', 'updatedAt', 'idCategory', 'selectedSery', 'selectedTags'], 'safe'],
            
            [['alias', 'metaTitle', 'title', 'faceImg', 'faceImgAlt'], 'string', 'max' => 255],
            [['selectedCategory'], 'exist', 'skipOnError' => true, 'targetClass' => BlogCategories::className(), 'targetAttribute' => ['selectedCategory' => 'id']],
            
//            ['title', function () {
//                if ($this->hasErrors('alias')) {
//                    $this->addError('title', Yii::t('app', 'Title is invalid.'));
//                }
//            }],
            
        ];
    }

//    public function checkRequiredFile($attribute, $params)
//    {
//        $validator = new yii\validators\RequiredValidator();
//        $this->addError($attribute, \Yii::t('app', 'Нужно загрузить картинку'));
//        
//        if ($this->isNewRecord && $validator->validate($attribute, $error)){
//            $this->addError($attribute, \Yii::t('app', 'Нужно загрузить картинку'));
//        }else{
//            if($this->faceImg === null && $validator->validate($attribute, $error)){
//                $this->addError($attribute, \Yii::t('app', 'Нужно загрузить картинку'));
//            }
//        }
//
//    }
    
//    public function scenarios()
//    {
//        $scenarios = [
//            'create' => ['selectedCategory', 'metaTitle', 'metaDesc', 'title', 'text', 'faceImg', 'faceImgAlt', 'flagActive', 'file'],
//            'update' => ['selectedCategory', 'metaTitle', 'metaDesc', 'title', 'text', 'faceImg', 'faceImgAlt', 'flagActive', 'file'],
//        ];
//
//        return ArrayHelper::merge(parent::scenarios(), $scenarios);
//    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/admin', 'ID'),
            'idCategory' => Yii::t('app/admin', 'Id Category'),
            'selectedCategory' => Yii::t('app/admin', 'Select category'),
            'selectedSery' => Yii::t('app/admin', 'Select sery'),
            'selectedTags' => Yii::t('app/admin', 'Select tags'),
            'alias' => Yii::t('app/admin', 'Alias'),
            'metaTitle' => Yii::t('app/admin', 'Meta Title'),
            'metaDesc' => Yii::t('app/admin', 'Meta Desc'),
            'metaKeywords' => Yii::t('app/admin', 'Meta Keywords'),
            'title' => Yii::t('app/admin', 'Title'),
            'text' => Yii::t('app/admin', 'Text'),
            'faceImg' => Yii::t('app/admin', 'Face Img'),
            'faceImgAlt' => Yii::t('app/admin', 'Face Img Alt'),
            'flagActive' => Yii::t('app/admin', 'Flag Active'),
            'createdAt' => Yii::t('app/admin', 'Created At'),
            'updatedAt' => Yii::t('app/admin', 'Updated At'),
            'createdBy' => Yii::t('app/admin', 'Created By'),
            'updatedBy' => Yii::t('app/admin', 'Updated By'),
            'viewCount' => Yii::t('app/admin', 'View Count'),
            'file' => 'Загрузка изображения',
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [//Использование поведения TimestampBehavior ActiveRecord
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['createdAt'],
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updatedAt'],

                ],
                'value' => function(){
                                return gmdate("Y-m-d H:i:s");
                },
            //'value' => new \yii\db\Expression('NOW()'),

            ],
            
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'metaTitle',
                'slugAttribute' => 'alias',
                'immutable' => true,//неизменный
                'ensureUnique'=>true,//генерировать уникальный
                
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'createdBy',
                'updatedByAttribute' => 'updatedBy',
            ],
            
            'purify' => [
                'class' => PurifyBehavior::className(),
                'attributes' => ['text'],
                'config' => function ($config) {
                                $def = $config->getHTMLDefinition(true);
                                $def->addElement('mark', 'Inline', 'Inline', 'Common');
                                $def->addElement('mark', 'Inline', 'Inline', 'Common');
                                $def->addAttribute('a', 'id', 'Text');
                                $def->addAttribute('img', 'class', 'Text');
                                $def->addAttribute('a', 'target', 'Text');
                                $def->addAttribute('a', 'name', 'ID');
                                $config->set('Attr.EnableID', true);
                                $config->set('HTML.SafeIframe', true);
                                $config->set('URI.SafeIframeRegexp', '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%'); //allow YouTube and Vimeo
                            }
            ]
        ];
    }
    
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord){
            $this->idCategory = $this->selectedCategory;
        }else{
            
        }if($this->selectedCategory !== $this->idCategory){
            $this->idCategory = $this->selectedCategory;
        }
        
//        var_dump($this->alias);die;
        
        return true;
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'createdBy']);
    }
    
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updatedBy']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(BlogCategories::className(), ['id' => 'idCategory']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticlesBlogSeries()
    {
        return $this->hasMany(BlogArticlesBlogSeries::className(), ['idArticle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeries()
    {
        return $this->hasMany(BlogSeries::className(), ['id' => 'idSery'])->viaTable('blogArticles_blogSeries', ['idArticle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogTagsBlogArticles()
    {
        return $this->hasMany(BlogTagsBlogArticles::className(), ['idBlogArticle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogTags()
    {
        return $this->hasMany(BlogTags::className(), ['id' => 'idBlogTag'])->viaTable('blogTags_blogArticles', ['idBlogArticle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getViewsStatisticArticles()
    {
        return $this->hasOne(ViewsStatisticArticles::className(), ['idArticle' => 'id']);
    }

    /**
     * @inheritdoc
     * @return BlogArticlesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogArticlesQuery(get_called_class());
    }
}
