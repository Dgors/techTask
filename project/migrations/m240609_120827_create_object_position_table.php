<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%object_position}}`.
 */
class m240609_120827_create_object_position_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%object_position}}', [
            'id' => $this->primaryKey(),
            'object_position_name' => $this->string()->notNull()->unique(),
        ]);

        $this->insert('object_position', [
            'object_position_name' => 'Монтажник',
        ]);
        $this->insert('object_position', [
            'object_position_name' => 'Агент',
        ]);
        $this->insert('object_position', [
            'object_position_name' => 'Выездной инженер',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%object_position}}');
    }
}
