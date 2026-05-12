<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ai_message}}`.
 */
class m260507_100937_create_ai_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ai_message}}', [

            'id' => $this->primaryKey(),

            // пользователь
            'user_id' => $this->integer()->notNull(),

            // идентификатор диалога
            'chat_id' => $this->string(64)->notNull(),

            // user / assistant / system
            'role' => $this->string(20)->notNull(),

            // сообщение
            'message' => $this->text()->notNull(),

            // дополнительные данные от AI
            'meta' => $this->json()->null(),

            // время создания
            'created_at' => $this->timestamp()
                ->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),

        ]);

        // FK
        $this->addForeignKey(
            'fk-ai_message-user_id',
            '{{%ai_message}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // INDEXES
        $this->createIndex(
            'idx-ai_message-user_id',
            '{{%ai_message}}',
            'user_id'
        );

        $this->createIndex(
            'idx-ai_message-chat_id',
            '{{%ai_message}}',
            'chat_id'
        );

        $this->createIndex(
            'idx-ai_message-role',
            '{{%ai_message}}',
            'role'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-ai_message-user_id',
            '{{%ai_message}}'
        );

        $this->dropIndex(
            'idx-ai_message-user_id',
            '{{%ai_message}}'
        );

        $this->dropIndex(
            'idx-ai_message-chat_id',
            '{{%ai_message}}'
        );

        $this->dropIndex(
            'idx-ai_message-role',
            '{{%ai_message}}'
        );

        $this->dropTable('{{%ai_message}}');
    }
}
