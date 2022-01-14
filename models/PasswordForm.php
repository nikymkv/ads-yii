<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class PasswordForm extends Model
{
    public $password;
    public $password_confirmation;

    public function rules()
    {
        return [
            [['password', 'password_confirmation'], 'required'],
            [['password', 'password_confirmation'], 'compare', 'compareAttribute' => 'password_confirmation'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'password_confirmation' => 'Подтверждение пароля',
        ];
    }
}
