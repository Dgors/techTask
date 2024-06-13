<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "object_object_position".
 *
 * @property int $object_id
 * @property int $object_position_id
 *
 * @property Object $object
 * @property ObjectPosition $objectPosition
 */
class ObjectObjectPosition extends \yii\db\ActiveRecord
{
    /**
     * @var bool|int|mixed|string|null
     */

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object_object_position';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object_id', 'object_position_id'], 'required'],
            [['object_id', 'object_position_id'], 'integer'],
            [['object_id', 'object_position_id'], 'unique', 'targetAttribute' => ['object_id', 'object_position_id']],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Objects::class, 'targetAttribute' => ['object_id' => 'id']],
            [['object_position_id'], 'exist', 'skipOnError' => true, 'targetClass' => ObjectPosition::class, 'targetAttribute' => ['object_position_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'object_id' => 'Object ID',
            'object_position_id' => 'Object Position ID',
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
     * Gets query for [[ObjectPosition]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjectPosition()
    {
        return $this->hasOne(ObjectPosition::class, ['id' => 'object_position_id']);
    }
}
