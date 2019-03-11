<?php

namespace frontend\services\fragments;


use frontend\repositories\blog\BlogRepositoryInterface;
use frontend\models\blog\articles\BlogArticles;
use frontend\models\blog\series\BlogSeries;

/**
 * Description of SideBarService
 *
 * @author Sergio Codev <codev>
 */
class SideBarService {
    
    private $blogRepository;


    public function __construct(BlogRepositoryInterface $blogRepository) {
        $this->blogRepository = $blogRepository;
    }

    public function shapeCategories(){
        $cats = $this->blogRepository->allCategoriesWichArtileCounts();
        
        $arr = [];
        
        foreach ($cats as $k => $cat){
            $arr[$k]['name_category'] = $cat['title'];
            $arr[$k]['alias_category'] = $cat['alias'];
            $arr[$k]['count_materials'] = $cat['count_materials'];
        }
        
        return $arr;
    }
    
    public function shapeTags(){
        $tags = $this->blogRepository->allTagsWichArtileCounts();
    
        $count = count($tags);
        
        $minInTag = $this->blogRepository->minTagWichArtileCount();
        $maxInTag = $this->blogRepository->maxTagWichArtileCount();//максимальное кол-во материалов в теге
        
        //ни одного материала с тегом нет
        if(!$maxInTag){
            return false;
        }
        
        //min and max font size
        $min_rem = ($count > 3) ? 0.8 : 1;
        $max_rem = 2;

        $step = ($max_rem - $min_rem) / $maxInTag;
        
        $tagsList = [];
        
        foreach($tags as $k => $v){
            $tagsList[$k]['title'] = $v['title'];
            $tagsList[$k]['alias'] = $v['alias'];
            $tagsList[$k]['count'] = $v['a_count'];
            
            //если тег с мимнмальным кол-вом материалов - задаем минимальный rem размер шрифта
            //и т.п.
            if( (int)$v['a_count'] ==  $minInTag){
                $tagsList[$k]['rem'] = $min_rem;
            }elseif ((int)$v['a_count'] ==  $maxInTag) {
                $tagsList[$k]['rem'] = $max_rem;
            }else{
                //вычисляем размер шрифта
                $tagsList[$k]['rem'] = $min_rem + ($step * $v['a_count']);
            }
             
        }
        
        return $tagsList;
    }
    
    public function shapeBestBlogMaterials($maxSize){
        $materials = BlogArticles::getBestArticlesAllTime($maxSize);
        
        $array = [];
        foreach($materials as $k => $v){
            $array[$k]['alias'] = $v->alias;
            $array[$k]['title'] = $v->title;
            $array[$k]['viewCount'] = $v->viewCount;
        }
        
        return $array;
//        var_dump($materials);die;
    }
    
    public function shapeArticlesBySeryToWidget($seryId){
       return BlogArticles::find()
                ->active()
                ->joinWith([
                        'series' => function ($query) use ($seryId) {
                            $query->andWhere([BlogSeries::tableName().'.id' => $seryId]);
                        },
                    ])
                    ->orderBy([BlogArticles::tableName().'.createdAt' => SORT_ASC])    
                    ->all();
    }
    
}
