<?php

/**
 * @package myblog
 * @file url-rules.php created 28.05.2018 22:22:44
 * 
 * @copyright Copyright (C) 2018 Sergio coderius <coderius>
 * @license This program is free software: GNU General Public License
 */

return [
    'default/create/<entity:[\w_-]+>' => 'default/create',
    'default/ajax-create/<entity:[\w_-]+>' => 'default/create',//AjaxCreate
//    'default/create' => 'default/create',
    'default/<action>' => 'default/<action>',
    
];