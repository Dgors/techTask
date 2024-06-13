<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "object_object_region".
 *
 * @property int $object_id
 * @property int $object_region_id
 *
 * @property Object $object
 * @property ObjectRegion $objectRegion
 */
class ObjectObjectRegion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object_object_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object_id', 'object_region_id'], 'required'],
            [['object_id', 'object_region_id'], 'integer'],
            [['object_id', 'object_region_id'], 'unique', 'targetAttribute' => ['object_id', 'object_region_id']],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Objects::class, 'targetAttribute' => ['object_id' => 'id']],
            [['object_region_id'], 'exist', 'skipOnError' => true, 'targetClass' => ObjectRegion::class, 'targetAttribute' => ['object_region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'object_id' => 'Object ID',
            'object_region_id' => 'Object Region ID',
        ];
    }

    /**
     * Gets query for [[Object]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(Objects::class, ['id' => 'object_id']);
    }

    /**
     * Gets query for [[ObjectRegion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjectRegion()
    {
        return $this->hasOne(ObjectRegion::class, ['id' => 'object_region_id']);
    }
}
