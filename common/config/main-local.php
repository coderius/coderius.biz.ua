<?php


$conf = [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=172.27.0.3;port=3306;dbname=coderius',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'on afterOpen' => function ($event) {
//                $expression1 = new \yii\db\Expression('
//                    DROP TRIGGER IF EXISTS `after_insert_view_statistic`;
//                    CREATE TRIGGER `after_insert_view_statistic`
//                    AFTER INSERT ON `viewsStatisticArticles`
//                    FOR EACH ROW BEGIN
//                        UPDATE `blogArticles`
//                        SET viewCount = (SELECT COUNT(viewsStatisticArticles.id) FROM `viewsStatisticArticles` WHERE viewsStatisticArticles.idArticle = blogArticles.id);
//                    END;');
//
//                $event->sender->createCommand($expression1)->execute();
//
//                $expression2 = new \yii\db\Expression('
//                    DROP TRIGGER IF EXISTS `after_update_view_statistic`;
//                    CREATE TRIGGER `after_update_view_statistic`
//                    AFTER UPDATE ON `viewsStatisticArticles`
//                    FOR EACH ROW BEGIN
//                        UPDATE `blogArticles`
//                        SET viewCount = (SELECT COUNT(viewsStatisticArticles.id) FROM `viewsStatisticArticles` WHERE viewsStatisticArticles.idArticle = blogArticles.id);
//                    END;');
//
//                $event->sender->createCommand($expression2)->execute();

                $expression3 = new \yii\db\Expression('
                    DROP TRIGGER IF EXISTS `after_delete_view_statistic`;
                    CREATE TRIGGER `after_delete_view_statistic` 
                    AFTER DELETE ON `viewsStatisticArticles` 
                    FOR EACH ROW BEGIN 
                        UPDATE `blogArticles`
                        SET viewCount = (SELECT COUNT(viewsStatisticArticles.id) FROM `viewsStatisticArticles` WHERE viewsStatisticArticles.idArticle = blogArticles.id);
                    END;');

                $event->sender->createCommand($expression3)->execute();
            },
        ],
//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            'viewPath' => '@common/mail',
//            // send all mails to a file by default. You have to set
//            // 'useFileTransport' to false and configure a transport
//            // for the mailer to send real emails.
//            'useFileTransport' => true,
//        ],
    ],
];

if (YII_WORK_SERVER) {
    $conf['components']['db']['dsn'] = 'mysql:host=localhost;dbname=user359826_coderius';
    $conf['components']['db']['username'] = 'coderius';
    $conf['components']['db']['password'] = 'R7n2T3k1';

    $conf['components']['db']['enableSchemaCache'] = true;
    $conf['components']['db']['schemaCacheDuration'] = 3600 * 24 * 10; //10 days
    $conf['components']['db']['schemaCache'] = 'cache';
}

return $conf;
