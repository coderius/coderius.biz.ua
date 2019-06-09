<?php

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => (3600*24),//24 houers

    'siteSlogan' => 'Сайт про веб программирование и IT.',
    'siteDescription' => 'Блог IT-шника, посвященный web разработке и технологиям программирования.',

    'srcImgArticleBig' => '@img-web-blog-posts/%id_article%/big/%src%',
    'srcImgArticleMid' => '@img-web-blog-posts/%id_article%/middle/%src%',

    'entities' => [
        'blog' => 'blog',
    ],

    'authType.site' => 1,
    'authType.facebook' => 2,
    'authType.google' => 3,
    'authType.github' => 4,
];
