<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "routes".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $from_address
 * @property string $to_address
 * @property int|null $distance
 * @property string|null $status
 * @property string $created_at
 * @property string|null $updated_at
 */
class Routes extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'routes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['distance', 'updated_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'active'],
            [['user_id', 'title', 'from_address', 'to_address', 'created_at'], 'required'],
            [['user_id', 'distance'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'from_address', 'to_address'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'from_address' => 'From Address',
            'to_address' => 'To Address',
            'distance' => 'Distance',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
