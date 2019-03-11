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
class NavigationTopEnum {
    const STATUS_ACTIVE = 1;
    const STATUS_DESIBLED = 0;
    
    public static $statusesName = [
        self::STATUS_ACTIVE => 'Активен',
        self::STATUS_DESIBLED => 'Отключен',
        ];
}
