<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%routes}}`.
 */
class m260507_164505_create_routes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%routes}}', [
            'id' => $this->primaryKey(),

            'user_id' => $this->integer()->notNull(),

            'title' => $this->string(255)->notNull(),

            'from_address' => $this->string(255)->notNull(),
            'to_address' => $this->string(255)->notNull(),

            'distance' => $this->integer()->null(),

            'status' => $this->string(50)->defaultValue('active'),

            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->null(),
        ]);

        $this->createIndex('idx-routes-user_id', '{{%routes}}', 'user_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%routes}}');
    }
}
