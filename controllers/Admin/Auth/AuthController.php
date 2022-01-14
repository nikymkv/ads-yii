<?php

namespace app\controllers\Admin\Auth;

use app\models\Moderator\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class AuthController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'get-login-form', 'logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'get-login-form'],
                        'allow' => true,
                        'roles' => ['?', '@'],
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
        $this->layout = '@app/views/admin/layout';
        $model = new LoginForm();
        return $this->render('@app/views/admin/auth/login', ['model' => $model]);
    }

    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();

        }
        return $this->goHome();

    }

    public function goHome()
    {
        return $this->response->redirect(['/']);
    }
}
