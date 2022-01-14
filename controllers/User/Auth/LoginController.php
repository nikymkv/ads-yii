<?php

namespace app\controllers\User\Auth;

use app\models\AuthForm\LoginForm;
use \yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class LoginController extends Controller
{
        /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'login' => ['post'],
                    'get-login-form' => ['get'],
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if (isset($_POST['LoginForm'])) {
            $model->attributes = Yii::$app->request->post('LoginForm');
            if ($model->validate()) {
                Yii::$app->user->login($model->user());
                return $this->goHome();
            }
        }

        return Yii::$app->response->redirect(['/login']);
    }

    public function actionGetLoginForm()
    {
        $this->layout = '@app/views/User/auth/layout';
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', ['model' => $model]);
        }

        $this->goHome();
    }

    public function actionLogout()
    {
        if (! Yii::$app->user->isGuest) {
            Yii::$app->user->logout();

            return $this->goHome();
        }

    }

    public function goHome()
    {
        return $this->response->redirect(Yii::$app->getHomeUrl());
    }

}
