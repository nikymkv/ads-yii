<?php

namespace app\controllers\User\Auth;

use app\models\AuthForm\LoginForm;
use app\models\AuthForm\RegisterForm;
use Yii;
use yii\base\Controller;

class RegisterController extends Controller
{
    public function actionGetRegisterForm()
    {
        $this->layout = '@app/views/User/auth/layout';
        if (Yii::$app->user->isGuest) {
            $model = new RegisterForm();
            return $this->render('register', ['model' => $model]);
        }

        return $this->response->redirect(Yii::$app->getHomeUrl());
    }

    public function actionRegister()
    {
        $model = new RegisterForm();
        if (isset($_POST['RegisterForm'])) {
            $model->attributes = Yii::$app->request->post('RegisterForm');
            if ($model->validate() && $model->register()) {
               $this->goLogin();
            }
        }

        return $this->render('register', ['model' => $model]);
    }

    protected function goLogin()
    {
        return $this->response->redirect(['/User/Auth/login/get-login-form']);
    }
}
