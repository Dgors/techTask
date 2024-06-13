<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "object_position".
 *
 * @property int $id
 * @property string $object_position_name
 *
 * @property ObjectObjectPosition[] $testObjectPositions
 * @property Objects[] $tests
 */
class ObjectPosition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object_position';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object_position_name'], 'required'],
            [['object_position_name'], 'string', 'max' => 255],
            [['object_position_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object_position_name' => 'Object Position Name',
        ];
    }

    /**
     * Gets query for [[TestObjectPositions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTestObjectPositions()
    {
        return $this->hasMany(ObjectObjectPosition::class, ['object_position_id' => 'id']);
    }

    /**
     * Gets query for [[Tests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Objects::class, ['id' => 'test_id'])->viaTable('test_object_position', ['object_position_id' => 'id']);
    }
}
