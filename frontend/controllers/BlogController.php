<?php
namespace frontend\controllers;

use Yii;
use frontend\services\blog\BlogService;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\blog\categories\BlogCategories;
use frontend\models\blog\articles\BlogArticles;

class BlogController extends BaseController
{
    const SECTION_NAME = 'Блог';
    const SECTION_NAME_FULL = 'Блог об архитектуре и  искусстве веб программирования';
    
    private $blogService;
    
    public $pageSize = 15;


    public function __construct($id, $module, BlogService $blogService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->blogService = $blogService;
    }
    
//    public function behaviors()
//    {
//        return [
//            [
//                'class' => 'yii\filters\HttpCache',
//                'only' => ['index'],
//                'lastModified' => function ($action, $params) {
//                    $q = new \yii\db\Query();
//                    $timestamp = strtotime($q->from('blogArticles')->max('updatedAt'));
//                    return $timestamp;
//                },
////                'sessionCacheLimiter' => 'public',         
//            ],
//             
//            [
//                'class' => 'yii\filters\HttpCache',
//                'only' => ['category'],
//                'lastModified' => function ($action, $params) {
//                    $alias = Yii::$app->request->queryParams['alias'];
//                    $q = new \yii\db\Query();
//                    $idCat = $q->from('blogCategories')->where(['alias' => $alias])->scalar();
//                    if($idCat){
//                        $time = (new \yii\db\Query())
//                            ->from('blogArticles')
//                            ->where(['idCategory' => $idCat])
//                            ->max('updatedAt');
////                    var_dump($time);die;
//                        return strtotime($time);
//                    }
//                    
//                },
//            ],            
//              
//            [
//                'class' => 'yii\filters\HttpCache',
//                'only' => ['sery'],
//                'lastModified' => function ($action, $params) {
//                    $alias = Yii::$app->request->queryParams['alias'];
//                    $q = new \yii\db\Query();
//                    $idSery = $q->from('blogSeries')->where(['alias' => $alias])->scalar();
//                    if($idSery){
//                        $time = (new \yii\db\Query())
//                            ->from('blogArticles_blogSeries')
//                            ->join('LEFT JOIN', 'blogArticles', 'blogArticles_blogSeries.idArticle = blogArticles.id')    
//                            ->where(['blogArticles_blogSeries.idSery' => $idSery])
//                            ->max('blogArticles.updatedAt');
////                    var_dump($time);die;
//                        return strtotime($time);
//                    }
//                    
//                },
//            ],            
//               
//            [
//                'class' => 'yii\filters\HttpCache',
//                'only' => ['tag'],
//                'lastModified' => function ($action, $params) {
//                    $alias = Yii::$app->request->queryParams['alias'];
//                    $q = new \yii\db\Query();
//                    $idTag = $q->from('blogTags')->where(['alias' => $alias])->scalar();
//                    if($idTag){
//                        $time = (new \yii\db\Query())
//                            ->from('blogTags_blogArticles')
//                            ->join('LEFT JOIN', 'blogArticles', 'blogTags_blogArticles.idBlogArticle = blogArticles.id')    
//                            ->where(['blogTags_blogArticles.idBlogTag' => $idTag])
//                            ->max('blogArticles.updatedAt');
////                    var_dump($time);die;
//                        return strtotime($time);
//                    }
//                    
//                },
//                        
//            ],            
//                        
//            [
//                'class' => 'yii\filters\HttpCache',
//                'only' => ['article'],
//                'lastModified' => function ($action, $params) {
//                    $alias = Yii::$app->request->queryParams['alias'];
//                    $q = (new \yii\db\Query())
//                            ->from('blogArticles')
//                            ->where(['alias' => $alias]);
//                    
//                    if($res = $q->one()){
//                        $timestamp = strtotime($res['updatedAt']);
//                        return $timestamp;
//                    }
//                    
//                    
//                },
//            ],            
//        ];
//    }
    
    public function beforeAction($action) {
        if ($action->id == 'index'){
            $this->view->params['breadcrumbs'][] = Html::encode(self::SECTION_NAME);
            
        }else{
            //ссылка на блог в хлебных крошках
            $this->view->params['breadcrumbs'][] = array('label'=> self::SECTION_NAME, 'url'=> Url::toRoute('/blog'));
        }
        
        return parent::beforeAction($action);
    }

    public function actionIndex($pageNum = null)
    {
//        $expression = new \yii\db\Expression('[[viewCount]]');
//        $model = BlogArticles::find()->where(['id' => 1])->one();
//    ->joinWith('category')
//    ->where([BlogCategories::tableName().'.id' => 1])
//    ->all();
//var_dump($model);
        
//        $model->findFor('Category', $model);
//$model->all();
//var_dump($model->getCategory());
        //для отладки
//        var_dump($model->getCategory()->createCommand()->sql);

//        $query->createCommand()->sql
        
////$model = \Yii::$app->db->createCommand('SELECT * FROM blogArticles')->queryAll();
//$model = (new \yii\db\Query())->select('*')->from('blogArticles')->where('flagActive=:flagActive');
//$model = $model->addParams([':flagActive' => 1]);
//$model = $model->all();

//    var_dump($model->findWith(['category' => function($model){return $model;}], $model));
              
        
//        foreach($model as $m){
//            echo $m->id;
//        }
        
        
//$category = BlogCategories::find()->with('ownArticles')->all();

//$category = BlogCategories::find()->with([
//    'ownArticles' => function ($query) {
//        $query->limit(1);
//    },
//])->all();
//        $articlesInCategory = $category->getBlogArticles()->active()->orderCreatedAt()->all();
        
//        $articlesInCategory = $category->getOwnArticles();
//        var_dump($category);
        
        $result = $this->blogService->getBlog($pageNum, $this->pageSize);
        
        list($articles, $confLinkPager) = $result;
        
        //Meta tags
        \Yii::$app->seo->putSeoTags([
            'title' => Html::encode(self::SECTION_NAME_FULL) . ": все посты",
            'description' => Html::encode(self::SECTION_NAME_FULL) . ".Как устроены фреймворки и как ими пользоваться, стать senior web developer и гуру кода и многое другое читайте на страницах блога. Добро пожаловать в рай :)",
            'keywords' => "программирование, php, пхп, yii2, laravel, simfony, web developer",
            'canonical' => Url::canonical(),
        ]);
        
        return $this->render('index',compact(
                'articles',
                'confLinkPager'
                ));
    }
    
    public function actionCategory($alias, $pageNum = null)
    {
        $result = $this->blogService->getCategory($alias, $pageNum, $this->pageSize);
        
        list($category, $articles, $confLinkPager) = $result;
        
        //Meta tags
        \Yii::$app->seo->putSeoTags([
            'title' => $category->metaTitle,
            'description' => $category->metaDesc,
            'keywords' => $category->metaKeywords,
            'canonical' => Url::canonical(),
        ]);
        
        return $this->render('category',compact(
                'category',
                'articles',
                'confLinkPager'
                ));
    }
    
    public function actionSery($alias, $pageNum = null)
    {
        
        $result = $this->blogService->getSery($alias, $pageNum, $this->pageSize);
        
        list($sery, $articles, $confLinkPager) = $result;
        
        //Meta tags
        \Yii::$app->seo->putSeoTags([
            'title' => $sery->metaTitle,
            'description' => $sery->metaDesc,
            'keywords' => $sery->metaKeywords,
            'canonical' => Url::canonical(),
        ]);
        
        return $this->render('sery',compact(
                'sery',
                'articles',
                'confLinkPager'
                ));
        
    }
    
    public function actionTag($alias, $pageNum = null)
    {
        $result = $this->blogService->getByTag($alias, $pageNum, $this->pageSize);
        
        list($tag, $articles, $confLinkPager) = $result;
        
        //Meta tags
        \Yii::$app->seo->putSeoTags([
            'title' => $tag->metaTitle,
            'description' => $tag->metaDescription,
            'keywords' => $tag->metaKeywords,
            'canonical' => Url::canonical(),
        ]);
        
        return $this->render('tag',compact(
                'tag',
                'articles',
                'confLinkPager'
                ));
    }
    
    public function actionArticle($alias)
    {
        $article = $this->blogService->getArticle($alias);
        
        //Meta tags
        \Yii::$app->seo->putSeoTags([
            'title' => $article->metaTitle,
            'description' => $article->metaDesc,
            'keywords' => $article->metaKeywords,
            'canonical' => Url::canonical(),
        ]);
        
        \Yii::$app->seo->putFacebookMetaTags([
            'og:url'        => Url::canonical(),
            'og:type'       => 'website',
            'og:title'      => $article->metaTitle,
            'og:description'=> $article->metaDesc,
            'og:image'      => Url::to("@img-web-blog-posts/$article->id/middle/$article->faceImg", true),
            'fb:app_id'=> '1811670458869631',//для статистики по переходам
//            'og:locale'=> 'ru_UKR',
        ]);
        
        \Yii::$app->seo->putTwitterMetaTags([
            'twitter:site'        => Url::canonical(),
            'twitter:title'       => $article->metaTitle,
            'twitter:description' => $article->metaDesc,
            'twitter:creator'     => 'Coderius',
            'twitter:image:src'      => Url::to("@img-web-blog-posts/$article->id/middle/$article->faceImg", true),
            'twitter:card'=> 'summary',

        ]);
        
        \Yii::$app->seo->putGooglePlusMetaTags([
            'name'        => $article->metaTitle,
            'description'=> $article->metaDesc,
            'image'      => Url::to("@img-web-blog-posts/$article->id/middle/$article->faceImg", true),
            
        ]);
        
        //Crumbs
        if($article->hasCategory()){
            \Yii::$app->view->params['breadcrumbs'][] = array('label'=> Html::encode($article->category->title), 'url'=> Url::toRoute(['/blog/category', 'alias' => $article->category->alias]));
        }
        \Yii::$app->view->params['breadcrumbs'][] = Html::encode($article->title);
        
        
        
        return $this->render('article',compact(
                'article'
                ));
    }
    
   
    
}

