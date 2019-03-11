<?php

namespace frontend\services\blog;

use yii;
use frontend\repositories\blog\BlogRepositoryInterface;
use yii\data\Pagination;
use yii\widgets\LinkPager;//для пагинации
use yii\helpers\Url;
use frontend\models\blog\articles\BlogArticles;
use frontend\models\blog\categories\BlogCategories;
use frontend\models\blog\tags\BlogTags;
use frontend\models\blog\series\BlogSeries;
use frontend\services\BaseService;
use common\components\rbac\Rbac;
use common\models\user\User;
/**
 * Description of BlogService
 *
 * @author Sergio Codev <codev>
 */
class BlogService extends BaseService{
    
    private $blogRepository;


    public function __construct(BlogRepositoryInterface $blogRepository) {
        $this->blogRepository = $blogRepository;
    }

    /**
     * 
     * @param type $alias
     * @return type
     * @throws \yii\web\HttpException
     */
    public function getArticle($alias){
        $onlyActive = true;
        if (\Yii::$app->user->can(Rbac::PERMISSION_ADMIN_PANEL)){
            $onlyActive = false;
        }
        $mArticle = BlogArticles::findArticleByAlias($alias, $onlyActive);
//        var_dump($mArticle);die;
        if($mArticle == NULL)
        {
            throw new \yii\web\HttpException(404, 'Такой страницы не существует. ');
            //throw new \yii\web\NotFoundHttpException;
        }
        //для админа счетчик не используем
        if(User::isNotAdmin()){
            $mArticle->trigger(BlogArticles::EVENT_NEW_VIEW);
        }
         
        
        return $mArticle;
    }
    
    public function getBlog($pageNum, $pageSize) {
        $countArticles = BlogArticles::countAllActiveArticles();
        $confLinkPager = self::confLinkPager($countArticles, 'pageNum', $pageSize);
        
        $offset = $confLinkPager['pagination']->offset;
        $limit = $confLinkPager['pagination']->limit;
        
        $countPagin = self::countPaginatePages($countArticles, $pageSize);
        
        //если в адресной строке введен номер пагинации, котрого нет - выводим
        if($pageNum > $countPagin)
        {
            throw new \yii\web\HttpException(404, 'Такой страницы не существует. ');
        }
        
        //если введена еденица, делаем редирект на без 1
        if($pageNum == 1)
        {
            Yii::$app->response->redirect(Url::toRoute(['/blog']));
        }
        
        $mKitArticles = BlogArticles::paginateActiveArticles($offset, $limit);
        
        return [$mKitArticles, $confLinkPager];
        
    }
    
    /**
     * 
     * @param type $aliasCategory
     * @param type $pageNum
     * @param type $pageSize кол-во материалов на странице
     */
    public function getCategory($aliasCategory, $pageNum, $pageSize) {
        $countArticles = BlogCategories::countAllActiveArticlesByCategoryAlias($aliasCategory);
        $confLinkPager = self::confLinkPager($countArticles, 'pageNum', $pageSize);
        
        $offset = $confLinkPager['pagination']->offset;
        $limit = $confLinkPager['pagination']->limit;
        
        $countPagin = self::countPaginatePages($countArticles, $pageSize);
        
        $mCategory = BlogCategories::findCategoryByAlias($aliasCategory);
        
        if(!$mCategory)
        {
            throw new \yii\web\HttpException(404, 'Такой страницы не существует. ');
            //throw new \yii\web\NotFoundHttpException;
        }
        
        //если введена еденица, делаем редирект на без 1
        if($pageNum == 1)
        {
            Yii::$app->response->redirect(Url::toRoute(['/blog/category', 'alias' => $aliasCategory]));
        }
        
        //если в адресной строке введен номер пагинации, котрого нет - выводим
        if($pageNum > $countPagin)
        {
            throw new \yii\web\HttpException(404, 'Такой страницы не существует. ');
        }
        
        $mKitArticles = BlogArticles::paginateActiveArticles($offset, $limit, $mCategory->id);

        return [$mCategory, $mKitArticles, $confLinkPager];
        
    }
    
    public function getByTag($aliasTag, $pageNum, $pageSize) {
        $countArticles = BlogTags::countAllActiveArticlesByTagAlias($aliasTag);
//        var_dump($countArticles); die;
        $confLinkPager = self::confLinkPager($countArticles, 'pageNum', $pageSize);
        
        $offset = $confLinkPager['pagination']->offset;
        $limit = $confLinkPager['pagination']->limit;
        
        $countPagin = self::countPaginatePages($countArticles, $pageSize);
        
        $mTag = BlogTags::findTagByAlias($aliasTag);
        
        if(!$mTag)
        {
            throw new \yii\web\HttpException(404, 'Такой страницы не существует. ');
            //throw new \yii\web\NotFoundHttpException;
        }
//        
        //если введена еденица, делаем редирект на без 1
        if($pageNum == 1)
        {
            Yii::$app->response->redirect(Url::toRoute(['/blog/tag', 'alias' => $aliasTag]));
        }
        
        //если в адресной строке введен номер пагинации, котрого нет - выводим
        if($pageNum > $countPagin)
        {
            throw new \yii\web\HttpException(404, 'Такой страницы не существует. ');
        }
        
        $mKitArticles = BlogArticles::paginateActiveArticles($offset, $limit, false, $mTag->id);
//        var_dump($mKitArticles);die;
        return [$mTag, $mKitArticles, $confLinkPager];
        
    }
    
    public function getSery($aliasSery, $pageNum, $pageSize) {
        $countArticles = BlogSeries::countAllActiveArticlesBySeryAlias($aliasSery);
//        var_dump($countArticles); die;
        $confLinkPager = self::confLinkPager($countArticles, 'pageNum', $pageSize);
        
        $offset = $confLinkPager['pagination']->offset;
        $limit = $confLinkPager['pagination']->limit;
        
        $countPagin = self::countPaginatePages($countArticles, $pageSize);
//        var_dump($countArticles);die;
        $mSery = BlogSeries::findSeryByAlias($aliasSery);
        
        
        if(!$mSery)
        {
            throw new \yii\web\HttpException(404, 'Такой страницы не существует. ');
            //throw new \yii\web\NotFoundHttpException;
        }
//        
        //если введена еденица, делаем редирект на без 1
        if($pageNum == 1)
        {
            Yii::$app->response->redirect(Url::toRoute(['/blog/sery', 'alias' => $aliasSery]));
        }
        
        //если в адресной строке введен номер пагинации, котрого нет - выводим
        if($pageNum > $countPagin)
        {
            throw new \yii\web\HttpException(404, 'Такой страницы не существует. ');
        }
        
        $mKitArticles = BlogArticles::paginateActiveArticles($offset, $limit, false, false, $mSery->id);
        
        return [$mSery, $mKitArticles, $confLinkPager];
        
    }
    
    private function getKits($mKitArticles){
        //формируем dto
        $arrayDtoArticle = [];
        
        $categoryInId = [];
        
        $seryInId = [];
        
        //кол-во просмотров
        $viewsSubjectsInId = [];
        
        //tags to articles
        $arrayDtoTagInArticle = [];
        
        //заполнение моделей
        foreach($mKitArticles as $mArticle){
            $arrayDtoArticle[] = $mArticle->getDto();
            
            //id categories relevant this article
            if($mArticle->idCategory){
                $categoryInId[] = $mArticle->idCategory;
            }
            
            //id series relevant this article
            if($mArticle->idSery){
                $seryInId[] = $mArticle->idSery;
            }

            $viewsSubjectsInId[] = $mArticle->id;
            
            //tags
            $mKitTags = $this->blogRepository->findTagsFromArticle($mArticle->id);
            
            if($mKitTags){
                foreach ($mKitTags as $mTag){
                    $arrayDtoTagInArticle[$mArticle->id][] = $mTag->getDto();
                }
            }
        }
        
        $mKitCategory = $this->blogRepository->findCategoriesById($categoryInId);
        $mKitSery = $this->blogRepository->findSeriesById($seryInId);
        $mKitViewsSubjects = $this->blogRepository->findViewsSubjectsByArticlesId($viewsSubjectsInId);

        
        
        //формируем dto
        $arrayDtoCategory = [];
        $arrayDtoSery = [];
        $arrayViewsSubjects = [];
        
        if($mKitCategory){
            foreach($mKitCategory as $id => $mCategory){
                $arrayDtoCategory[$id] = $mCategory->getDto();
            }
        }

        
        if($mKitSery){
            foreach($mKitSery as $id => $mSery){
                $arrayDtoSery[$id] = $mSery->getDto();
            }
        }
        
        if($mKitViewsSubjects){
            foreach($mKitViewsSubjects as $id => $mViewsSubject){
                $arrayViewsSubjects[$id] = $mViewsSubject->getDto();
            }
        }
//        var_dump($arrayViewsSubjects);die;
        return [$arrayDtoArticle, $arrayDtoCategory, $arrayDtoTagInArticle, $arrayDtoSery, $arrayViewsSubjects];
        
    }
    
    
    /**
     * 
     * @param type $totalCount
     * @param type $pageSize
     * @return type
     */
    public static function countPaginatePages($totalCount, $pageSize){
        return ceil($totalCount / $pageSize);
    }
    
    
    
    
    
    
    
}
