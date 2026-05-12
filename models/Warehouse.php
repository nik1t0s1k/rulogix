<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "warehouse".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $address
 * @property int $capacity
 * @property int $used_capacity
 * @property string|null $status
 * @property string $created_at
 * @property string|null $updated_at
 */
class Warehouse extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'warehouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['updated_at'], 'default', 'value' => null],
            [['used_capacity'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 'active'],
            [['user_id', 'name', 'address', 'created_at'], 'required'],
            [['user_id', 'capacity', 'used_capacity'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'address'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'address' => 'Address',
            'capacity' => 'Capacity',
            'used_capacity' => 'Used Capacity',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
