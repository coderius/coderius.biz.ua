<?php

namespace frontend\models\blog\articles;

use Yii;
use frontend\models\blog\tags\BlogTags;
use frontend\models\blog\categories\BlogCategories;
use frontend\models\blog\series\BlogSeries;
use yii\helpers\Url;
use common\models\statistic\ViewsStatisticArticles;
use common\models\user\User;
use common\enum\SiteSubjectsEnum;
use common\enum\BlogEnum;

/**
 * This is the model class for table "blogArticles".
 *
 * @property int    $id
 * @property int    $idCategory
 * @property string $alias
 * @property string $metaTitle
 * @property string $metaDesc
 * @property string metaKeywords
 * @property string                 $title
 * @property string                 $text
 * @property string                 $faceImg
 * @property string                 $faceImgAlt
 * @property int                    $flagActive
 * @property string                 $createdAt
 * @property string                 $updatedAt
 * @property int                    $createdBy
 * @property int                    $updatedBy
 * @property int                    $viewCount
 * @property BlogCategories         $category
 * @property BlogTagsBlogArticles[] $blogTagsBlogArticles
 * @property BlogTags[]             $blogTags
 * @property ViewsStatisticArticles $viewsStatisticArticles
 */
class BlogArticles extends \yii\db\ActiveRecord
{
    const EVENT_NEW_VIEW = 'new-view'; //событие просмотра статьи

    public function init()
    {
        $this->on(self::EVENT_NEW_VIEW, [$this, 'registerVisit']);

        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blogArticles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idCategory', 'alias', 'metaTitle', 'metaDesc', 'title', 'text', 'faceImg', 'faceImgAlt', 'createdBy', 'updatedBy'], 'required'],
            [['idCategory', 'flagActive', 'createdBy', 'updatedBy', 'viewCount'], 'integer'],
            [['metaDesc', 'text'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['alias', 'metaTitle', 'title', 'faceImg', 'faceImgAlt'], 'string', 'max' => 255],
            [['idCategory'], 'exist', 'skipOnError' => true, 'targetClass' => BlogCategories::className(), 'targetAttribute' => ['idCategory' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'idCategory' => Yii::t('app', 'Id Category'),
            'alias' => Yii::t('app', 'Alias'),
            'metaTitle' => Yii::t('app', 'Meta Title'),
            'metaDesc' => Yii::t('app', 'Meta Desc'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'faceImg' => Yii::t('app', 'Face Img'),
            'faceImgAlt' => Yii::t('app', 'Face Img Alt'),
            'flagActive' => Yii::t('app', 'Flag Active'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'createdBy' => Yii::t('app', 'Created By'),
            'updatedBy' => Yii::t('app', 'Updated By'),
            'viewCount' => Yii::t('app', 'View Count'),
        ];
    }

    //обработчик события
    public function registerVisit($event)
    {
        $connection = \Yii::$app->db;
//        $connection->on(\yii\db\Connection::EVENT_BEGIN_TRANSACTION, function ($event) {
//            echo \yii\db\Connection::EVENT_BEGIN_TRANSACTION;
//        });
//
//        $connection->on(\yii\db\Connection::EVENT_COMMIT_TRANSACTION, function ($event) {
//            echo \yii\db\Connection::EVENT_COMMIT_TRANSACTION;
//        });
//
//        $connection->on(\yii\db\Connection::EVENT_ROLLBACK_TRANSACTION, function ($event) {
//            echo \yii\db\Connection::EVENT_ROLLBACK_TRANSACTION;
//        });

        $transaction = $connection->beginTransaction();
        try {
            $statistic = new ViewsStatisticArticles([
                'idArticle' => $this->id,
                'ip' => \Yii::$app->request->userIP,
            ]);

            if ($statistic->save()) {
                //при удалении из ViewsStatisticArticles используется триггер для обновления viewCount
                //из main-local.php
                $this->updateCounters(['viewCount' => 1]);
                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollback();
        }
//        var_dump($event->sender); die;
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

    public function getSery()
    {
        return $this->hasOne(BlogSeries::className(), ['id' => 'idSery'])->viaTable('blogArticles_blogSeries', ['idArticle' => 'id']);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'createdBy']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updatedBy']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getViewsStatisticArticles()
    {
        return $this->hasOne(ViewsStatisticArticles::className(), ['idArticle' => 'id']);
    }

    public static function findArticleByAlias($alias, $onlyActive = true)
    {
        $query = self::find()->andWhere(['alias' => $alias]);
        if ($onlyActive) {
            $query->active();
        }

        return $query->one();
    }

    public static function getBestArticlesAllTime($limit = 7)
    {
        return self::find()->active()->limit($limit)->orderBy(['viewCount' => SORT_DESC])->all();
    }

    public static function countAllActiveArticles()
    {
        return self::find()->active()->count();
    }

    public static function paginateActiveArticles($offset, $limit, $categoryId = false, $tagId = false, $seryId = false)
    {
        $obj = self::find()->active();

        if ($categoryId) {
            $obj->andWhere(['idCategory' => $categoryId]);
        }

        //meny to meny
        if ($tagId) {
            $obj->joinWith([
                        'blogTags' => function ($query) use ($tagId) {
                            $query->andWhere([BlogTags::tableName().'.id' => $tagId]);
                        },
                    ]);
        }

        if ($seryId) {
            $obj->joinWith([
                        'series' => function ($query) use ($seryId) {
                            $query->andWhere([BlogSeries::tableName().'.id' => $seryId]);
                        },
                    ]);
        }

        $res = $obj
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy(['createdAt' => SORT_DESC])
                    ->all();

//         var_dump($res); die;
        return $res;
    }

    public function hasArticles()
    {
        return (bool) self::find()->active()->count();
    }

    public function hasTags()
    {
        return (bool) $this->getBlogTags()->count();
    }

    public function hasCategory()
    {
        return (bool) $this->getCategory()->count();
    }

    public function hasSery()
    {
        return (bool) $this->getSeries()->count();
    }

    public function hasAuthor()
    {
        return null !== User::findOne($this->createdBy);
    }

    public function hasUpdater()
    {
        return null !== User::findOne($this->updatedBy);
    }

    // public function hasComments(){
    //     if(Yii::$app->getModule('comments') !== null){
    //         $commentsModel = Yii::$app->getModule('comments')->model('Comments');
    //         return $commentsModel::hasComments(SiteSubjectsEnum::BLOG_ARTICLE, $this->id);
    //     }

    //     return false;
    // }

    public function getUrl($scheme = false)
    {
        return Url::toRoute(['/blog/article', 'alias' => $this->alias], $scheme);
    }

//    public function getUrlWichScheme($scheme = false){
//        return Url::toRoute(['/blog/article', 'alias' => $this->alias], $scheme);
//    }
    //для карты сайта
    public function getLastMod()
    {
        return $this->updatedAt ? $this->updatedAt : $this->createdAt;
    }

    public function getIsActive()
    {
        return $this->flagActive === BlogEnum::ACTIVE_STATUS;
    }

    /**
     * {@inheritdoc}
     *
     * @return BlogArticlesQuery the active query used by this AR class
     */
    public static function find()
    {
        return new BlogArticlesQuery(get_called_class());
    }
}
