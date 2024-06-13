<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%object_object_region}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%object}}`
 * - `{{%object_region}}`
 */
class m240612_150501_create_junction_table_for_object_and_object_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%object_object_region}}', [
            'object_id' => $this->integer(),
            'object_region_id' => $this->integer(),
            'PRIMARY KEY(object_id, object_region_id)',
        ]);

        for ($i = 1; $i <= 100000; $i++) {
            $this->insert('{{%object_object_region}}', [
                'object_id' => $i,
                'object_region_id' => random_int(1, 2),
            ]);
        }

        // creates index for column `object_id`
        $this->createIndex(
            '{{%idx-object_object_region-object_id}}',
            '{{%object_object_region}}',
            'object_id'
        );

        // add foreign key for table `{{%object}}`
        $this->addForeignKey(
            '{{%fk-object_object_region-object_id}}',
            '{{%object_object_region}}',
            'object_id',
            '{{%object}}',
            'id',
            'CASCADE'
        );

        // creates index for column `object_region_id`
        $this->createIndex(
            '{{%idx-object_object_region-object_region_id}}',
            '{{%object_object_region}}',
            'object_region_id'
        );

        // add foreign key for table `{{%object_region}}`
        $this->addForeignKey(
            '{{%fk-object_object_region-object_region_id}}',
            '{{%object_object_region}}',
            'object_region_id',
            '{{%object_region}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%object}}`
        $this->dropForeignKey(
            '{{%fk-object_object_region-object_id}}',
            '{{%object_object_region}}'
        );

        // drops index for column `object_id`
        $this->dropIndex(
            '{{%idx-object_object_region-object_id}}',
            '{{%object_object_region}}'
        );

        // drops foreign key for table `{{%object_region}}`
        $this->dropForeignKey(
            '{{%fk-object_object_region-object_region_id}}',
            '{{%object_object_region}}'
        );

        // drops index for column `object_region_id`
        $this->dropIndex(
            '{{%idx-object_object_region-object_region_id}}',
            '{{%object_object_region}}'
        );

        $this->dropTable('{{%object_object_region}}');
    }
}
