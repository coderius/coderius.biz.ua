<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%social_auth}}`.
 */
class m190609_043914_create_user_social_auth_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_social_auth}}', [
            'id' => $this->integer()->notNull(),
            'user_id' => $this->integer(10)->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
            'nickname' => $this->string()->notNull(),
            'avatar' => $this->string()->null(),

        ]);
        
        $this->addPrimaryKey('pk-id', '{{%user_social_auth}}', 'id');
        $this->alterColumn('{{%user_social_auth}}', 'id', $this->integer() . ' UNSIGNED NOT NULL AUTO_INCREMENT');
        $this->alterColumn('{{%user_social_auth}}', 'user_id', $this->integer(10) . ' UNSIGNED NOT NULL');
        
        $this->createIndex('idx-user_id', '{{%user_social_auth}}', 'user_id');
        $this->createIndex('idx-source', '{{%user_social_auth}}', 'source');
        $this->createIndex('source_id', '{{%user_social_auth}}', 'source_id');
        $this->addForeignKey('fk-user_social_auth-user_id-user-id', '{{%user_social_auth}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_social_auth}}');
    }
}
