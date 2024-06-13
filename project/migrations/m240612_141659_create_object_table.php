<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%object}}`.
 */
class m240612_141659_create_object_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%object}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'x_position' => $this->float()->notNull(),
            'y_position' => $this->float()->notNull(),
        ]);

        $this->createIndex(
            '{{%unique_index_column}}',
            '{{%object}}',
            ['x_position', 'y_position'],
            true
        );

        // Массив для уникальных координат
        $uniqueCoordinates = array();

        // Функция для рандомных координат
        function generateRandomCoordinates($radius = 100, $center = [55.044, 82.915]) {
            $minX = $center[0] - $radius / 111.32;
            $maxX = $center[0] + $radius / 111.32;
            $minY = $center[1] - $radius / (111.32 * cos($center[0] * pi() / 180));
            $maxY = $center[1] + $radius / (111.32 * cos($center[0] * pi() / 180));

            // Генерация случайной широты
            $latitude = random_int($minX * 1000, $maxX * 1000) / 1000;
            // Генерация случайной долготы
            $longitude = random_int($minY * 1000, $maxY * 1000) / 1000;

            return [$latitude, $longitude];
        }

// Генерация 100000 случайных координат
        for ($i = 0; $i < 100000; $i++) {
            $coordinates = generateRandomCoordinates();

            while(in_array($coordinates, $uniqueCoordinates)) {
                //var_dump($coordinates);
                $coordinates = generateRandomCoordinates();
            }

            $uniqueCoordinates[] = $coordinates;

            $this->insert('object', [
                'name' => 'Object#' . ($i + 1),
                'x_position' => $coordinates[1],
                'y_position' => $coordinates[0],
            ]);

        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%object}}');
    }
}
