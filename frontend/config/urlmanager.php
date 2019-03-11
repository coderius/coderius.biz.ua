<?php
return [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => $baseUrl,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [

//                '/' => 'site/index',
//                'site/<action>' => 'site/<action>',

                'sitemap.xml' => 'sitemap/index',
                'rss.xml' => 'rss/index',
                
                '/' => 'site/index',
//                'login' => 'site/login',
//                'logout' => 'site/logout',
//                'signup' => 'site/signup',
                
                '<action:(login|logout|signup)>' => 'site/<action>',
                
                'search/<pageNum:\d+>' => 'search/index',
                'search' => 'search/index',
                
                
                'blog/<pageNum:\d+>' => 'blog/index',//пагинация блога
                'blog' => 'blog/index',
                
                
                'blog/category/<alias:[\w_-]+>/<pageNum:\d+>' => 'blog/category',
                'blog/category/<alias:[\w_-]+>' => 'blog/category',
                
                'blog/sery/<alias:[\w_-]+>/<pageNum:\d+>' => 'blog/sery',
                'blog/sery/<alias:[\w_-]+>' => 'blog/sery',
                
                'blog/tag/<alias:[\w_-]+>/<pageNum:\d+>' => 'blog/tag',
                'blog/tag/<alias:[\w_-]+>' => 'blog/tag',
                
                'blog/article/<alias:[\w_-]+>' => 'blog/article',
                
                
                
//                'articles/category/<alias:[\w_-]+>/<pageNum:\d+>' => 'blog/category',//категория по алиасу с цифрой страницы пагинации(articles/category/cat1/2)
//                'articles/<action:[\w-]+>/<alias:[\w_-]+>' => 'blog/<action>',//пост по алиасу(articles/post/cdscdsc), категория по алиасу(articles/category/cat1)
                
                
              
                
            ],
        ];
?>
