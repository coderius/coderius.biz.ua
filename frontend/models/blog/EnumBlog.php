<?php

/**
 * @package myblog
 * @file EnumBlog.php created 01.03.2018 14:10:22
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */
namespace frontend\models\blog;


class EnumBlog{
    
    const TABLE_BLOGARTICLES = 'blogArticles';
    const TABLE_BLOGCATEGORIES = 'blogCategories';
    const TABLE_BLOGTAGS_BLOGARTICLES = 'blogTags_blogArticles';
    const TABLE_BLOGTAGS = 'blogTags';
    const TABLE_BLOGSERIES = 'blogSeries';
    const TABLE_VIEWSSTATISTICARTICLES = 'viewsStatisticArticles';
    
    const ARTICLE_STATUS_ACTIVE = 1;
    const ARTICLE_STATUS_HIDDEN = 2;
    
}