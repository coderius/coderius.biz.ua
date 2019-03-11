<?php

namespace frontend\services\blog;

use yii;
use frontend\repositories\blog\BlogRepositoryInterface;
use yii\data\Pagination;
use yii\widgets\LinkPager;//для пагинации
use yii\helpers\Url;
/**
 * Description of BlogService
 *
 * @author Sergio Codev <codev>
 */
class BlogService {
    
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
        $mArticle = $this->blogRepository->findArticleByAlias($alias);
        
        if($mArticle == NULL)
        {
            throw new \yii\web\HttpException(404, 'Такой страницы не существует. ');
            //throw new \yii\web\NotFoundHttpException;
        }
        
        $mCategory = $this->blogRepository->findCategoryById($mArticle->idCategory);
        
        $mArticlesInSery = $this->blogRepository->findArticleBySeryId($mArticle->idSery);
        
        $arrayArticlesInSeryWidget = [];
//        var_dump($mArticlesInSery);
        if($mArticlesInSery){
            foreach($mArticlesInSery as $k => $v){
                $arrayArticlesInSeryWidget[$k]['title'] = $v->title;
                $arrayArticlesInSeryWidget[$k]['url'] = Url::toRoute(['/blog/article', 'alias' => $v->alias]);
            } 
        }
        
        $dtoArticle = $mArticle->getDto();
        $dtoCategory = $mCategory->getDto();
        
        
        
        return [$dtoArticle, $dtoCategory, $arrayArticlesInSeryWidget];
    }
    
    public function getBlog($pageNum, $pageSize) {
        $countArticles = $this->blogRepository->countArticles();
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
        
        $mKitArticles = $this->blogRepository->findArticles($offset, $limit);
        

        list($arrayDtoArticle, $arrayDtoCategory, $arrayDtoTagInArticle, $arrayDtoSery, $arrayViewsSubjects) = $this->getKits($mKitArticles);
        
        return [$arrayDtoArticle, $arrayDtoCategory, $arrayDtoTagInArticle, $arrayViewsSubjects, $arrayDtoSery, $confLinkPager];
        
    }
    
    /**
     * 
     * @param type $aliasCategory
     * @param type $pageNum
     * @param type $pageSize кол-во материалов на странице
     */
    public function getCategory($aliasCategory, $pageNum, $pageSize) {
        $countArticles = $this->blogRepository->countArticlesFromCategotyAlias($aliasCategory);
        $confLinkPager = self::confLinkPager($countArticles, 'pageNum', $pageSize);
        
        $offset = $confLinkPager['pagination']->offset;
        $limit = $confLinkPager['pagination']->limit;
        
        $countPagin = self::countPaginatePages($countArticles, $pageSize);
        
        $mCategory = $this->blogRepository->findCategoryByAlias($aliasCategory);
        
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
        
        $mKitArticles = $this->blogRepository->findArticlesFromCategoty($mCategory->id, $offset, $limit);

        list($arrayDtoArticle, $arrayDtoCategory, $arrayDtoTagInArticle, $arrayDtoSery) = $this->getKits($mKitArticles);
        
        return [$arrayDtoArticle, $arrayDtoCategory, $arrayDtoTagInArticle, $arrayDtoSery, $mCategory->getDto(), $confLinkPager];
        
    }
    
    public function getByTag($aliasTag, $pageNum, $pageSize) {
        $countArticles = $this->blogRepository->countArticlesFromTagAlias($aliasTag);
//        var_dump($countArticles); die;
        $confLinkPager = self::confLinkPager($countArticles, 'pageNum', $pageSize);
        
        $offset = $confLinkPager['pagination']->offset;
        $limit = $confLinkPager['pagination']->limit;
        
        $countPagin = self::countPaginatePages($countArticles, $pageSize);
        
        $mTag = $this->blogRepository->findTagByAlias($aliasTag);
        $dtoTag = $mTag->getDto();
        
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
        
        $mKitArticles = $this->blogRepository->findArticlesFromTag($mTag->id, $offset, $limit);
        
        list($arrayDtoArticle, $arrayDtoCategory, $arrayDtoTagInArticle, $arrayDtoSery) = $this->getKits($mKitArticles);
        
        return [$arrayDtoArticle, $arrayDtoCategory, $arrayDtoTagInArticle, $arrayDtoSery, $dtoTag, $confLinkPager];
        
    }
    
        public function getSery($aliasSery, $pageNum, $pageSize) {
        $countArticles = $this->blogRepository->countArticlesFromSeryAlias($aliasSery);
//        var_dump($countArticles); die;
        $confLinkPager = self::confLinkPager($countArticles, 'pageNum', $pageSize);
        
        $offset = $confLinkPager['pagination']->offset;
        $limit = $confLinkPager['pagination']->limit;
        
        $countPagin = self::countPaginatePages($countArticles, $pageSize);
        
        $mSery = $this->blogRepository->findSeryByAlias($aliasSery);
        $dtoSery = $mSery->getDto();
        
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
        
        $mKitArticles = $this->blogRepository->findArticlesFromSery($mSery->id, $offset, $limit);
        
        list($arrayDtoArticle, $arrayDtoCategory, $arrayDtoTagInArticle, $arrayDtoSery) = $this->getKits($mKitArticles);
        
        return [$arrayDtoArticle, $arrayDtoCategory, $arrayDtoTagInArticle, $arrayDtoSery, $dtoSery, $confLinkPager];
        
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
    
    /**
     * 
     * @param type $totalCount
     * @param type $pageParam
     * @param type $pageSize
     * @return array
     */
    public static function confLinkPager($totalCount, $pageParam, $pageSize){
        $confPagination = [
                'totalCount' => $totalCount,//количество страниц
                'pageSize' => $pageSize,//кол-во материалов на странице
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageParam' => $pageParam,
                
                ];
        
        $confLinkPager = [
                'pagination' => new \yii\data\Pagination($confPagination),
                'hideOnSinglePage' => true,
                'maxButtonCount' => 6,
                'firstPageLabel' => 'Вначало',
                'lastPageLabel' => 'Вконец',
                'options' => ['class' => 'pagination'],
                'pageCssClass' => 'pagination-row',
                'prevPageCssClass' => 'pagination-row prev',
                'nextPageCssClass' => 'pagination-row next',
                'lastPageCssClass' => 'pagination-row last',
                'activePageCssClass' => 'pagination-row--active',
                'linkOptions' => ['class'=> 'pagination-row-num'],
            ];
        
        
            return $confLinkPager;
    }
    
    
    
    
    
}
