<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "object".
 *
 * @property int $id
 * @property string $name
 * @property float $x_position
 * @property float $y_position
 *
 * @property ObjectObjectPosition[] $objectObjectPositions
 * @property ObjectObjectRegion[] $objectObjectRegions
 * @property ObjectPosition[] $objectPositions
 * @property ObjectRegion[] $objectRegions
 */
class Objects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'x_position', 'y_position'], 'required'],
            [['x_position', 'y_position'], 'number', 'min' => 0],
            [['name'], 'string', 'max' => 255],
            [['x_position', 'y_position'], 'unique', 'targetAttribute' => ['x_position', 'y_position']],
            [['x_position'], 'number', 'max' => 90],
            [['y_position'], 'number', 'max' => 180],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'x_position' => 'X Position',
            'y_position' => 'Y Position',
        ];
    }

    /**
     * Gets query for [[ObjectObjectPositions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjectObjectPositions()
    {
        return $this->hasMany(ObjectObjectPosition::class, ['object_id' => 'id']);
    }

    /**
     * Gets query for [[ObjectObjectRegions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjectObjectRegions()
    {
        return $this->hasMany(ObjectObjectRegion::class, ['object_id' => 'id']);
    }

    /**
     * Gets query for [[ObjectPositions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjectPositions()
    {
        return $this->hasOne(ObjectPosition::class, ['id' => 'object_position_id'])->viaTable('object_object_position', ['object_id' => 'id']);
    }

    /**
     * Gets query for [[ObjectRegions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjectRegions()
    {
        return $this->hasOne(ObjectRegion::class, ['id' => 'object_region_id'])->viaTable('object_object_region', ['object_id' => 'id']);
    }
}
