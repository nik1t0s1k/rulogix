<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transport".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $status
 * @property string $from_address
 * @property string $to_address
 * @property int|null $cargo_weight
 * @property int $user_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 */
class Transport extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 'pending';
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_IN_TRANSIT = 'in_transit';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    public static function statusList()
    {
        return [
            'pending' => 'Ожидает',
            'assigned' => 'Назначено',
            'in_transit' => 'В пути',
            'delivered' => 'Доставлено',
            'cancelled' => 'Отменено',
        ];
    }
    public static function getStatusLabel($status)
    {
        $status = strtolower($status);

        return self::statusList()[$status] ?? $status;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transport';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'from_address', 'to_address'], 'required'],
            [['description'], 'string'],
            [['cargo_weight'], 'integer'],
            [['status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'from_address' => 'From Address',
            'to_address' => 'To Address',
            'cargo_weight' => 'Cargo Weight',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
