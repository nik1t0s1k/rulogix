<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ai_chat}}`.
 */
class m260507_152544_create_ai_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ai_chat}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->defaultValue('New chat'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-ai_chat-user_id',
            '{{%ai_chat}}',
            'user_id'
        );
        $this->addForeignKey(
            'fk-ai_chat-user_id',
            '{{%ai_chat}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%ai_chat}}');
    }
}
