<?php

namespace app\models\Moderator;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass' => User::class, 'targetAttribute' => ['email' => 'email']],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        $user = $this->user();
        if ($user === null || !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Пароль или почта введены неверно!');
        }
    }

    public function user()
    {
        return User::findOne(['email' => $this->email]);
    }
}
