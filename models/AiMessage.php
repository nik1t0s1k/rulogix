<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ai_message".
 *
 * @property int $id
 * @property int $user_id
 * @property string $chat_id
 * @property string $role
 * @property string $message
 * @property string|null $meta
 * @property string $created_at
 *
 * @property User $user
 */
class AiMessage extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ai_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meta'], 'default', 'value' => null],
            [['user_id', 'chat_id', 'role', 'message'], 'required'],
            [['user_id'], 'integer'],
            [['message'], 'string'],
            [['meta', 'created_at'], 'safe'],
            [['chat_id'], 'string', 'max' => 64],
            [['role'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'chat_id' => 'Chat ID',
            'role' => 'Role',
            'message' => 'Message',
            'meta' => 'Meta',
            'created_at' => 'Created At',
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
