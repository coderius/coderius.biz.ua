<?php
//var_dump(dirname(__DIR__) .'/translations');die;
return [
    'components' => [
        // перевод
        'i18n' => [
            'class' => 'yii\i18n\I18N',
            'translations' => [
                'comments*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => dirname(__DIR__) .'/translations',
                    //'sourceLanguage' => 'en-US',
                    'forceTranslation' => true,
                    'fileMap' => [
                        'comments/messages'  => 'messages.php',
                    ],
                ],
                
            ],
        ],
    ],
    'params' => [
        // список параметров
    ],
];
