<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class Signup extends Model
{
    public $username;
    public $email;
    public $password;
    public $full_name;
    public $avatar;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],

            [['full_name', 'avatar'], 'default', 'value' => null],

            [['username'], 'string', 'max' => 50],
            [['email', 'full_name'], 'string', 'max' => 100],
            [['password', 'avatar'], 'string', 'max' => 255],

            [['username'], 'unique', 'targetClass' => User::class, 'message' => 'Логин уже занят'],
            [['email'], 'unique', 'targetClass' => User::class, 'message' => 'Почта уже занята'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'full_name' => 'Full Name',
            'avatar' => 'Avatar',
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();

        $user->username = $this->username;
        $user->email = $this->email;

        // важно: пароль должен хешироваться внутри модели User
        $user->setPassword($this->password);

        $user->role = 'user';

        $user->full_name = $this->full_name;
        $user->avatar = $this->avatar;


        if ($user->save()) {
            return $user;
        }

        return null;
    }
}