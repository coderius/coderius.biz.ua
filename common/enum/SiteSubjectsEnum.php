<?php

/**
 * @package myblog
 * @file NavigationTopEnum.php created 17.04.2018 22:12:54
 * 
 * @copyright Copyright (C) 2018 Sergio coderius <coderius>
 * @license This program is free software: GNU General Public License
 */
namespace common\enum;


/**
 * Description of NavigationTopEnum
 *
 * @author Sergio coderius <coderius>
 */
class SiteSubjectsEnum {
    const BLOG_ARTICLE = "blog_article";
    
    
    public static $statusesName = [
        self::BLOG_ARTICLE => 'Записи блога',
        ];
}
