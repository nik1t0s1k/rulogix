<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class ProfileForm extends Model
{
    public $username;
    public $email;
    public $full_name;
    public $avatar; // файл

    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['username'], 'string', 'max' => 50],
            [['email', 'full_name'], 'string', 'max' => 100],
            ['email', 'email'],

            ['avatar', 'file',
                'extensions' => ['png', 'jpg', 'jpeg', 'webp'],
                'maxSize' => 1024 * 1024 * 2 // 2MB
            ],
        ];
    }

    public function loadFromUser($user)
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $this->full_name = $user->full_name;
    }

    public function save($user)
    {
        if (!$this->validate()) {
            return false;
        }

        $user->username = $this->username;
        $user->email = $this->email;
        $user->full_name = $this->full_name;

        // загрузка аватара
        $file = UploadedFile::getInstance($this, 'avatar');

        if ($file) {
            $fileName = 'avatar_' . $user->id . '.' . $file->extension;
            $path = Yii::getAlias('@webroot/uploads/') . $fileName;

            if ($file->saveAs($path)) {
                $user->avatar = '/uploads/' . $fileName;
            }
        }

        return $user->save();
    }
}