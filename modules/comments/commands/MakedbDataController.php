<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace modules\comments\commands;

use yii\console\Controller;
use Yii;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MakedbDataController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'Ok')
    {
        $connection = Yii::$app->db;
        
        $connection->createCommand()
                ->batchInsert('comments', self::makeItems(), 
                    self::makeData()
                )
                ->execute();

        echo $message;
    }
    
    private static function makeItems(){
        return [
            'entity',
            'entityId',
            'content',
            'createdAt',
            
        ];
    }
    
    private static function makeData(){
        $res = [];
        for($i=0; $i < 10; $i++){
            $res[] = [
            'blog-article',
            20,
            'content #'.$i,
            gmdate("Y-m-d H:i:s"),
            ];
        }
        
        return $res;
    }
}
