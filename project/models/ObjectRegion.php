<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "object_region".
 *
 * @property int $id
 * @property string $region
 *
 * @property ObjectObjectRegion[] $testObjectRegions
 * @property Objects[] $tests
 */
class ObjectRegion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region'], 'required'],
            [['region'], 'string', 'max' => 255],
            [['region'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region' => 'Region',
        ];
    }

    /**
     * Gets query for [[TestObjectRegions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTestObjectRegions()
    {
        return $this->hasMany(ObjectObjectRegion::class, ['object_region_id' => 'id']);
    }

    /**
     * Gets query for [[Tests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::class, ['id' => 'test_id'])->viaTable('test_object_region', ['object_region_id' => 'id']);
    }
}
