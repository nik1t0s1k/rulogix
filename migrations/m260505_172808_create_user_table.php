<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m260505_172808_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),

            // базовая авторизация
            'username' => $this->string(50)->notNull()->unique(),
            'email' => $this->string(100)->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'role' => $this->string(30)->notNull()->defaultValue('user'),

            // профиль (оставлено из нового)
            'full_name' => $this->string(100)->null(),
            'avatar' => $this->string(255)->null(),

            // системные поля
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
