<?php

use yii\db\Migration;

/**
 * Class m180707_133312_comments
 */
class m180707_133312_comments extends Migration
{
    
    const TABLENAME = '{{%comments}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ('mysql' === $this->db->driverName) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(self::TABLENAME, [
            'id' => $this->primaryKey(),
            'entity' => $this->string()->notNull(),
            'entityId' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'parentId' => $this->integer()->null(),
            'level' => $this->smallInteger()->notNull()->defaultValue(1),
            'createdBy' => $this->integer()->null(). ' UNSIGNED',
            'updatedBy' => $this->integer()->null(). ' UNSIGNED',
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'createdAt' => $this->datetime()->notNull(),
            'updatedAt' => $this->datetime()->null(),
        ], $tableOptions);
        
        $this->createIndex('idx-comments-entity', self::TABLENAME, 'entity');
        $this->createIndex('idx-comments-status', self::TABLENAME, 'status');
        $this->createIndex('idx-comments-parentId', self::TABLENAME, 'parentId');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLENAME);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180707_133312_comments cannot be reverted.\n";

        return false;
    }
    */
}
