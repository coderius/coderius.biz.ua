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
    
    private $connection;

    public function __construct() {
        $this->connection = \Yii::$app->db;
    }
    
    
    
    /**
     * **************************************************************************
     *                          for sidebar
     * **************************************************************************
     */
    public function allCategoriesWichArtileCounts(){
        $params = [];
        
        $command = "SELECT * , "
                . "(SELECT COUNT(ba.id) from ".EnumBlog::TABLE_BLOGARTICLES." as ba WHERE ba.idCategory = bc.id AND ba.flagActive = 1) "
                . "as count_materials "
                . "FROM ".EnumBlog::TABLE_BLOGCATEGORIES." as bc "
                . "ORDER BY sort_order ASC";
        
        return $this->connection->createCommand($command)->bindValues($params)->queryAll();
    }
    //Теги, где записей больше нуля
    public function allTagsWichArtileCounts(){
        $params = [];
        
        $command = "SELECT * , "
                . "(SELECT COUNT(bt_ba.id) from ".EnumBlog::TABLE_BLOGTAGS_BLOGARTICLES." as bt_ba WHERE bt_ba.idBlogTag = bt.id) "
                . "as a_count "
                . "FROM ".EnumBlog::TABLE_BLOGTAGS." as bt "
                . "HAVING a_count > 0";
        
        return $this->connection->createCommand($command)->bindValues($params)->queryAll();
    }
    
    /**
     * Find tag wich minimal articles
     * @return type
     */
    public function minTagWichArtileCount(){
        $params = [];
        
        $command = "SELECT MIN(mycount) as cnt FROM (SELECT bt.idBlogTag,COUNT(bt.idBlogTag) AS mycount FROM ".EnumBlog::TABLE_BLOGTAGS_BLOGARTICLES." as bt GROUP BY bt.idBlogTag) AS t";
        
        $res = $this->connection->createCommand($command)->bindValues($params)->queryOne();
        
        return $res['cnt'];
    }
    
    /**
     * Find tag wich minimal articles
     * @return type
     */
    public function maxTagWichArtileCount(){
        $params = [];
        
        $command = "SELECT MAX(mycount) as cnt FROM (SELECT bt.idBlogTag,COUNT(bt.idBlogTag) AS mycount FROM ".EnumBlog::TABLE_BLOGTAGS_BLOGARTICLES." as bt GROUP BY bt.idBlogTag) AS t";
        
        $res = $this->connection->createCommand($command)->bindValues($params)->queryOne();
    
        return $res['cnt'];
    }

    /**
     * 
     * @param type $maxSize is a count of materials
     * @return type
     * метод пока не используется
     */
    public function bestBlogMaterials($maxSize, $flagActive = EnumBlog::ARTICLE_STATUS_ACTIVE){
        $params = [':maxSize' => $maxSize, ':flagActive' => $flagActive, ':section' => SubjectsModel::BLOG];
        
        $command = "SELECT vs.count, vs.itemId, s.title as section_name, "
                . "ba.alias, ba.title "
                . "FROM ".EnumBlog::TABLE_VIEWSSUBJECTS." AS vs "
                . "LEFT JOIN ".EnumBlog::TABLE_SUBJECTS." AS s ON vs.subjectId = s.id "
                . "AND s.title = :section "
                . "JOIN ".EnumBlog::TABLE_BLOGARTICLES." AS ba ON ba.id = vs.itemId "
                . "AND ba.flagActive = :flagActive ORDER BY vs.count DESC LIMIT :maxSize";
        
        return $this->connection->createCommand($command)->bindValues($params)->queryAll();
    }
    
    
}    