<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%object_region}}`.
 */
class m240609_120548_create_object_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%object_region}}', [
            'id' => $this->primaryKey(),
            'region' => $this->string()->notNull()->unique(),
        ]);

        $this->insert('object_region', [
           'region' => 'Север',
        ]);
        $this->insert('object_region', [
            'region' => 'Юг',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%object_region}}');
    }
}
