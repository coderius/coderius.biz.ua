<?php
//@app: Your application root directory (either frontend or backend or console depending on where you access it from)
//@vendor: Your vendor directory on your root app install directory
//@runtime: Your application files runtime/cache storage folder
//@web: Your application base url path
//@webroot: Your application web root
//@tests: Your console tests directory
//@common: Alias for your common root folder on your root app install directory
//@frontend: Alias for your frontend root folder on your root app install directory
//@backend: Alias for your backend root folder on your root app install directory
//@console: Alias for your console root folder on your root app install directory

return [
    '@bower' => '@vendor/bower-asset',
    '@npm'   => '@vendor/npm-asset',

//    ПУТИ К ИЗОБРАЖЕНИЯМ КОНТЕНТА

    '@img-web' =>  $baseUrl.'/images',//для веб
    '@img-path' => '@frontend/web/images',//для файловой системы

    '@img-web-blog' =>  $baseUrl.'/images/blog',//для веб
    '@img-path-blog' => '@frontend/web/images/blog',//для файловой системы
    
    '@img-web-blog-posts' =>  $baseUrl.'/images/blog/posts',//для веб
    '@img-path-blog-posts' => '@frontend/web/images/blog/posts',//для файловой системы
        
    '@img-web-users' =>  $baseUrl.'/images/users',//для веб
    '@img-path-users' => '@frontend/web/images/users',//для файловой системы
    
    '@img-web-admins' =>  $baseUrl.'/images/admins',//для веб
    '@img-path-admins' => '@frontend/web/images/admins',//для файловой системы
    
    ];