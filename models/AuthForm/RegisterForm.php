<?php

namespace app\models\AuthForm;

use app\models\User;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $rememberMe = true;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['name', 'email', 'password', 'password_confirmation'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => \app\models\User::class],
            ['password', 'string', 'min' => 4, 'max' => 32],
            ['password_confirmation', 'compare', 'compareAttribute'=>'password', 'message'=>"Пароли не совпадают!"],
        ];
    }

    public function register()
    {
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->setPassword($this->password);

        return $user->save();
    }
}
