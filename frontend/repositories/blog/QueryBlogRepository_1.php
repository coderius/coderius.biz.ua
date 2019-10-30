<?php

/**
 * @package myblog
 * @file BlogRepository.php created 09.02.2018 19:26:22
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */

namespace frontend\repositories\blog;

use yii\db\Query;
use frontend\models\blog\EnumBlog;
use frontend\models\blog\CategoryModel;
use frontend\models\blog\TagModel;
use frontend\models\blog\SeryModel;
use frontend\models\blog\SubjectsModel;
use frontend\models\blog\ViewsSubjectsModel;


/**
 * Description of BlogRepository
 *
 * @author Sergio Codev <codev>
 */
class QueryBlogRepository implements BlogRepositoryInterface{
    
    const TABLE_BLOGARTICLES = 'blogArticles';
    const TABLE_BLOGCATEGORIES = 'blogCategories';
    const TABLE_BLOGTAGS_BLOGARTICLES = 'blogTags_blogArticles';
    const TABLE_BLOGTAGS = 'blogTags';
    const TABLE_BLOGSERIES = 'blogSeries';
    const TABLE_VIEWSSUBJECTS = 'viewsSubjects';
    const TABLE_SUBJECTS = 'subjects';
    
    private $query;
    private $connection;

    public function __construct(Query $query) {
        $this->query = $query;
        $this->connection = \Yii::$app->db;
    }
    
    public function findArticleByAlias($alias, $flagActive = ArticleModel::STATUS_ACTIVE) {
        $article = $this->query
                ->select(['*'])
                ->from(self::TABLE_BLOGARTICLES)
                ->where([
                    'alias' => $alias,
                    'flagActive' => $flagActive,
                    ])
                ->one();
        
        if($article === null){
            return false;
        }
//        var_dump($article);die;
        $mArticle = new ArticleModel();
        $mArticle->load($article, '');

        return $mArticle;
    }
    
        public function findArticleBySeryId($idSery, $flagActive = ArticleModel::STATUS_ACTIVE) {
        $articles = $this->query
                ->select([self::TABLE_BLOGARTICLES.'.*'])
                ->from(self::TABLE_BLOGARTICLES)
                ->join('JOIN', self::TABLE_BLOGSERIES, self::TABLE_BLOGSERIES.'.id = '.self::TABLE_BLOGARTICLES.'.idSery')
                ->where([
                    'idSery' => $idSery,
                    'flagActive' => $flagActive,
                    ])
                ->orderBy([
                    'createdAt' => SORT_DESC,
//                    'updatedAt' => SORT_DESC,
                ])
                ->all();
        
        if($articles === null){
            return false;
        }

        $mArticles = [];
        
        foreach($articles as $article){
            $mArticle = new ArticleModel();
            $mArticle->load($article, '');
            $mArticles[] = $mArticle;
        }
//        var_dump($articles);die;
        return $mArticles;
    }
    
    public function findCategoryById($id) {
        $category = $this->query
                ->select(['*'])
                ->from(self::TABLE_BLOGCATEGORIES)
                ->where(['id' => $id])
                ->one();
        
        if($category == null){
            return false;
        }
        
        $mCategory = new CategoryModel();
        $mCategory->load($category, '');
        
        return $mCategory;
    }
    
    /**
     * 
     * @param type $id array
     * @return boolean|CategoryModel
     */
    public function findCategoriesById($id = []) {
//        var_dump($id);die;
        $categories = (new Query())
                ->select(['*'])
                ->from(self::TABLE_BLOGCATEGORIES)
                ->where(['id' => $id])
                ->distinct()
                ->all();
        
        if($categories == null){
            return false;
        }
        
        $mCategories = [];
        
        foreach($categories as $category){
            $mCategory = new CategoryModel();
            $mCategory->load($category, '');
            $mCategories[$mCategory->id] = $mCategory;
        }
        
        return $mCategories;
    }
    
    /**
     * 
     * @param type $id
     * @return boolean|CategoryModel
     * 
     * Выбор серий по id
     */
    public function findSeriesById($id = []){
        $series = (new Query())
                ->select(['*'])
                ->from(self::TABLE_BLOGSERIES)
                ->where(['id' => $id])
                ->distinct()
                ->all();
        
        if($series == null){
            return false;
        }
        
        $mSeries = [];
        
        foreach($series as $sery){
            $mSery = new SeryModel();
            $mSery->load($sery, '');
            $mSeries[$mSery->id] = $mSery;
        }
//        var_dump($mSeries);die;
        return $mSeries;
    }
    
    public function findViewsSubjectsByArticlesId($id = []){
        $res = (new Query())
                ->select([self::TABLE_VIEWSSUBJECTS.'.*'])
                ->from(self::TABLE_VIEWSSUBJECTS)
                ->join('JOIN', self::TABLE_SUBJECTS, self::TABLE_SUBJECTS.'.id = '.self::TABLE_VIEWSSUBJECTS.'.subjectId')
                ->where([
                    self::TABLE_SUBJECTS.'.title' => SubjectsModel::BLOG,
                    self::TABLE_VIEWSSUBJECTS.'.itemId' => $id,
                        ])
//                ->distinct()
                ->all();
        
        
        
        if($res == null){
            return false;
        }
        
        $mViewsSubjects = [];
        
        foreach($res as $ViewsSubject){
            $mViewsSubject = new ViewsSubjectsModel();
            $mViewsSubject->load($ViewsSubject, '');
            $mViewsSubjects[$mViewsSubject->itemId] = $mViewsSubject;
        }
//        var_dump($mSeries);die;
        return $mViewsSubjects;
    }

    public function findCategoryByAlias($alias) {
        $category = (new Query())
                ->select(['*'])
                ->from(self::TABLE_BLOGCATEGORIES)
                ->where(['alias' => $alias])
                ->one();
        
        if($category == null){
            return false;
        }
        
        $mCategory = new CategoryModel();
        $mCategory->load($category, '');
        
        return $mCategory;
    }
    
    public function findSeryByAlias($alias) {
        $sery = (new Query())
                ->select(['*'])
                ->from(self::TABLE_BLOGSERIES)
                ->where(['alias' => $alias])
                ->one();
        
        if($sery == null){
            return false;
        }
        
        $mSery = new SeryModel();
        $mSery->load($sery, '');
        
        return $mSery;
    }
    
    public function findArticles($offset, $limit, $flagActive = ArticleModel::STATUS_ACTIVE) {
        $articles = (new Query())
                ->select(['*'])
                ->from(self::TABLE_BLOGARTICLES)
                ->where([
                    'flagActive' => $flagActive,
                    ])
                ->offset($offset)
                ->limit($limit)
                ->orderBy([
                    'createdAt' => SORT_DESC,
//                    'updatedAt' => SORT_DESC,
                ])
                ->all();
        
        if($articles === null){
            return false;
        }
        
        $mArticles = [];
        
        foreach($articles as $article){
            $mArticle = new ArticleModel();
            $mArticle->load($article, '');
            $mArticles[] = $mArticle;
        }
        
        return $mArticles;
        
    }
    
    public function findTagByAlias($aliasTag){
        $tag = (new Query())
                ->select(['*'])
                ->from(self::TABLE_BLOGTAGS)
                ->where(['alias' => $aliasTag])
                ->one();
        
        if($tag == null){
            return false;
        }
        
        $mTag = new TagModel();
        $mTag->load($tag, '');
        
        return $mTag;
    }


    public function findArticlesFromCategoty($idCategory, $offset, $limit, $flagActive = ArticleModel::STATUS_ACTIVE) {
        $articles = (new Query())
                ->select(['*'])
                ->from(self::TABLE_BLOGARTICLES)
                ->where([
                    'idCategory' => $idCategory,
                    'flagActive' => $flagActive,
                    ])
                ->offset($offset)
                ->limit($limit)
                ->orderBy([
                    'createdAt' => SORT_DESC,
//                    'updatedAt' => SORT_DESC,
                ])
                ->all();
        
        if($articles === null){
            return false;
        }
        
        $mArticles = [];
        
        foreach($articles as $article){
            $mArticle = new ArticleModel();
            $mArticle->load($article, '');
            $mArticles[] = $mArticle;
        }
        
        return $mArticles;
        
    }
    
        public function findArticlesFromSery($idSery, $offset, $limit, $flagActive = ArticleModel::STATUS_ACTIVE) {
        $articles = (new Query())
                ->select([self::TABLE_BLOGARTICLES.'.*'])
                ->from(self::TABLE_BLOGARTICLES)
                ->where([
                    'idSery' => $idSery,
                    'flagActive' => $flagActive,
                    ])
                ->offset($offset)
                ->limit($limit)
                ->orderBy([
                    'createdAt' => SORT_DESC,
                    
                ])
                ->all();
        
        if($articles === null){
            return false;
        }
        
        $mArticles = [];
        
        foreach($articles as $article){
            $mArticle = new ArticleModel();
            $mArticle->load($article, '');
            $mArticles[] = $mArticle;
        }
        
        return $mArticles;
        
    }
    
    public function findArticlesFromTag($tagId, $offset, $limit, $flagActive = ArticleModel::STATUS_ACTIVE){
        $articles = (new Query())
                ->select([self::TABLE_BLOGARTICLES.'.*'])
                ->from(self::TABLE_BLOGARTICLES)
                ->join('JOIN', self::TABLE_BLOGTAGS_BLOGARTICLES, self::TABLE_BLOGARTICLES.'.id = '.self::TABLE_BLOGTAGS_BLOGARTICLES.'.idBlogArticle')
                ->where([
                    self::TABLE_BLOGTAGS_BLOGARTICLES.'.idBlogTag' => $tagId,
                    self::TABLE_BLOGARTICLES.'.flagActive' => $flagActive,
                    ])
                ->offset($offset)
                ->limit($limit)
                ->orderBy([
                    self::TABLE_BLOGARTICLES.'.createdAt' => SORT_DESC,
//                    'updatedAt' => SORT_DESC,
                ])
                ->all();
        
        if($articles === null){
            return false;
        }
        
        $mArticles = [];
//        var_dump($articles);die;
        foreach($articles as $article){
            $mArticle = new ArticleModel();
            $mArticle->load($article, '');
            $mArticles[] = $mArticle;
        }
        
        return $mArticles;
    }

    
    public function findTagsFromArticle($articleId){
        $tags = (new Query())
                ->select(['*'])
                ->from(self::TABLE_BLOGTAGS)
                ->join('JOIN', self::TABLE_BLOGTAGS_BLOGARTICLES, self::TABLE_BLOGTAGS.'.id = '.self::TABLE_BLOGTAGS_BLOGARTICLES.'.idBlogTag')
                ->where([
                    self::TABLE_BLOGTAGS_BLOGARTICLES.'.idBlogArticle' => $articleId
                    ])
                ->orderBy([
                    self::TABLE_BLOGTAGS.'.title' => SORT_DESC,
//                    'updatedAt' => SORT_DESC,
                ])
                ->all();
        
        if($tags === null){
            return false;
        }
        
        $mTags = [];
        
        foreach($tags as $tag){
            $mTag = new TagModel();
            $mTag->load($tag, '');
            $mTags[] = $mTag;
        }
        
        return $mTags;
    }

        public function countArticlesFromCategotyId($idCategory, $flagActive = ArticleModel::STATUS_ACTIVE) {
        return (new Query())
                ->from(self::TABLE_BLOGARTICLES)
                ->where([
                    'idCategory' => $idCategory,
                    'flagActive' => $flagActive,
                    ])
                ->count();
    }
    
    public function countArticles($flagActive = ArticleModel::STATUS_ACTIVE) {
        return (new Query())
                ->from(self::TABLE_BLOGARTICLES)
                ->where([
                    'flagActive' => $flagActive,
                    ])
                ->count();
    }
    
    /**
     * 
     * @param type $aliasCategory
     * @return type
     * Количество записей у категории по алиасу категории
     */
    public function countArticlesFromCategotyAlias($aliasCategory, $flagActive = ArticleModel::STATUS_ACTIVE) {
        
        $params = [':alias' => $aliasCategory, 'flagActive' => $flagActive];
        
        $command = "SELECT COUNT(*) FROM ".self::TABLE_BLOGARTICLES.
                " AS b "
                . "WHERE b.flagActive =:flagActive "
                . "AND b.idCategory IN "
                . "(SELECT c.id FROM ".self::TABLE_BLOGCATEGORIES." AS c WHERE c.alias =:alias)";
        
        return $this->connection->createCommand($command)->bindValues($params)->queryScalar();
        
//        
//        $subQuery = $this->query
//                ->from(self::TABLE_BLOGCATEGORIES. " AS cat")
//                ->where(['cat.alias' => $aliasCategory])
//                ->one();
//        
//        $query = $this->query
//                ->select('*')
//                ->from(self::TABLE_BLOGARTICLES. " AS a")
//                ->where(['a.idCategory' => $subQuery])
//                ->count();
//        return $query;
        
    }
    
    public function countArticlesFromTagAlias($aliasTag, $flagActiveArticle = ArticleModel::STATUS_ACTIVE) {
        
        $params = [':aliasTag' => $aliasTag, ':flagActiveArticle' => $flagActiveArticle];
        
        $command = "SELECT COUNT(a.id) FROM ".self::TABLE_BLOGARTICLES." AS a 
                    WHERE a.flagActive =:flagActiveArticle AND a.id IN
                    (SELECT ta.idBlogArticle FROM ".self::TABLE_BLOGTAGS_BLOGARTICLES." AS ta 
                    JOIN ".self::TABLE_BLOGTAGS." AS t ON ta.idBlogTag = t.id 
                    WHERE t.alias=:aliasTag)";
        
        
        
        return $this->connection->createCommand($command)->bindValues($params)->queryScalar();
    }
    
    public function countArticlesFromSeryAlias($alias, $flagActive = ArticleModel::STATUS_ACTIVE) {
        
        $params = [':alias' => $alias, 'flagActive' => $flagActive];
        
        $command = "SELECT COUNT(*) FROM ".self::TABLE_BLOGARTICLES.
                " AS b "
                . "WHERE b.flagActive =:flagActive "
                . "AND b.idSery IN "
                . "(SELECT s.id FROM ".self::TABLE_BLOGSERIES." AS s WHERE s.alias =:alias)";
        
        return $this->connection->createCommand($command)->bindValues($params)->queryScalar();
        
    }
    
    /**
     * **************************************************************************
     *                          for sidebar
     * **************************************************************************
     */
    public function allCategoriesWichArtileCounts(){
        $params = [];
        
        $command = "SELECT * , "
                . "(SELECT COUNT(ba.id) from ".self::TABLE_BLOGARTICLES." as ba WHERE ba.idCategory = bc.id) "
                . "as count_materials "
                . "FROM ".self::TABLE_BLOGCATEGORIES." as bc "
                . "ORDER BY sort_order ASC";
        
        return $this->connection->createCommand($command)->bindValues($params)->queryAll();
    }
    
    public function allTagsWichArtileCounts(){
        $params = [];
        
        $command = "SELECT * , "
                . "(SELECT COUNT(bt_ba.id) from ".self::TABLE_BLOGTAGS_BLOGARTICLES." as bt_ba WHERE bt_ba.idBlogTag = bt.id) "
                . "as a_count "
                . "FROM ".self::TABLE_BLOGTAGS." as bt";
        
        return $this->connection->createCommand($command)->bindValues($params)->queryAll();
    }
    
    public function minTagWichArtileCount(){
        $params = [];
        
        $command = "SELECT MIN(mycount) as cnt FROM (SELECT bt.idBlogTag,COUNT(bt.idBlogTag) AS mycount FROM ".self::TABLE_BLOGTAGS_BLOGARTICLES." as bt GROUP BY bt.idBlogTag) AS t";
        
        return $this->connection->createCommand($command)->bindValues($params)->queryOne();
    }
    
    public function maxTagWichArtileCount(){
        $params = [];
        
        $command = "SELECT MAX(mycount) as cnt FROM (SELECT bt.idBlogTag,COUNT(bt.idBlogTag) AS mycount FROM ".self::TABLE_BLOGTAGS_BLOGARTICLES." as bt GROUP BY bt.idBlogTag) AS t";
        
        return $this->connection->createCommand($command)->bindValues($params)->queryOne();
    }

    /**
     * 
     * @param type $maxSize is a count of materials
     * @return type
     */
    public function bestBlogMaterials($maxSize, $flagActive = EnumBlog::ARTICLE_STATUS_ACTIVE){
        $params = [':maxSize' => $maxSize, ':flagActive' => $flagActive, ':section' => SubjectsModel::BLOG];
        
        $command = "SELECT vs.count, vs.itemId, s.title as section_name, "
                . "ba.alias, ba.title "
                . "FROM ".self::TABLE_VIEWSSUBJECTS." AS vs "
                . "LEFT JOIN ".self::TABLE_SUBJECTS." AS s ON vs.subjectId = s.id "
                . "AND s.title = :section "
                . "JOIN ".self::TABLE_BLOGARTICLES." AS ba ON ba.id = vs.itemId "
                . "AND ba.flagActive = :flagActive ORDER BY vs.count DESC LIMIT :maxSize";
        
        return $this->connection->createCommand($command)->bindValues($params)->queryAll();
    }
    
    
}    