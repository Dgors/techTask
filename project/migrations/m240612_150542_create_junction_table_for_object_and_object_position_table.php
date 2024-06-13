<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%object_object_position}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%object}}`
 * - `{{%object_position}}`
 */
class m240612_150542_create_junction_table_for_object_and_object_position_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%object_object_position}}', [
            'object_id' => $this->integer(),
            'object_position_id' => $this->integer(),
            'PRIMARY KEY(object_id, object_position_id)',
        ]);

        for ($i = 1; $i <= 100000; $i++) {
            $this->insert('{{%object_object_position}}', [
                'object_id' => $i,
                'object_position_id' => random_int(1, 3),
            ]);
        }

        // creates index for column `object_id`
        $this->createIndex(
            '{{%idx-object_object_position-object_id}}',
            '{{%object_object_position}}',
            'object_id'
        );

        // add foreign key for table `{{%object}}`
        $this->addForeignKey(
            '{{%fk-object_object_position-object_id}}',
            '{{%object_object_position}}',
            'object_id',
            '{{%object}}',
            'id',
            'CASCADE'
        );

        // creates index for column `object_position_id`
        $this->createIndex(
            '{{%idx-object_object_position-object_position_id}}',
            '{{%object_object_position}}',
            'object_position_id'
        );

        // add foreign key for table `{{%object_position}}`
        $this->addForeignKey(
            '{{%fk-object_object_position-object_position_id}}',
            '{{%object_object_position}}',
            'object_position_id',
            '{{%object_position}}',
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
            '{{%fk-object_object_position-object_id}}',
            '{{%object_object_position}}'
        );

        // drops index for column `object_id`
        $this->dropIndex(
            '{{%idx-object_object_position-object_id}}',
            '{{%object_object_position}}'
        );

        // drops foreign key for table `{{%object_position}}`
        $this->dropForeignKey(
            '{{%fk-object_object_position-object_position_id}}',
            '{{%object_object_position}}'
        );

        // drops index for column `object_position_id`
        $this->dropIndex(
            '{{%idx-object_object_position-object_position_id}}',
            '{{%object_object_position}}'
        );

        $this->dropTable('{{%object_object_position}}');
    }
}
