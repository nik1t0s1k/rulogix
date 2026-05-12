<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%warehouse}}`.
 */
class m260507_164452_create_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%warehouse}}', [
            'id' => $this->primaryKey(),

            'user_id' => $this->integer()->notNull(),

            'name' => $this->string(255)->notNull(),
            'address' => $this->string(255)->notNull(),

            'capacity' => $this->integer()->notNull()->defaultValue(0),
            'used_capacity' => $this->integer()->notNull()->defaultValue(0),

            'status' => $this->string(50)->defaultValue('active'),

            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->null(),
        ]);

        $this->createIndex('idx-warehouse-user_id', '{{%warehouse}}', 'user_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%warehouse}}');
    }
}
