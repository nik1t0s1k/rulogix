<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transport}}`.
 */
class m260506_145222_create_transport_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transport}}', [
            'id' => $this->primaryKey(),

            'title' => $this->string(255)->notNull(), // название перевозки
            'description' => $this->text()->null(),

            'status' => $this->string(30)->notNull()->defaultValue('pending'),

            // pending | in_progress | done | cancelled

            'from_address' => $this->string(255)->notNull(),
            'to_address' => $this->string(255)->notNull(),

            'cargo_weight' => $this->integer()->null(),

            'user_id' => $this->integer()->notNull(),

            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()
                ->defaultExpression('CURRENT_TIMESTAMP')
                ->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-transport-user',
            '{{%transport}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%transport}}');
    }
}
