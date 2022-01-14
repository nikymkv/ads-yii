<?php

namespace app\controllers\User;

use app\models\PasswordForm;
use app\models\Location;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AccountController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'get-settings', 'save-settings', 'save-password'],
                'rules' => [
                    [
                        'actions' => ['index', 'get-settings', 'save-settings', 'save-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->response->redirect(['/login']);
                }
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'get-settings' => ['get'],
                    'save-settings' => ['post'],
                    'save-password' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $activeAds = $user->getAds()->where('status=1')->orderBy('created_at DESC')->all();
        $onModerationAds = $user->getAds()->where('status=2')->orderBy('created_at DESC')->all();
        $rejectedAds = $user->getAds()->where('status=3')->orderBy('created_at DESC')->all();

        $this->layout = '@app/views/User/auth/layout';

        return $this->render('index', [
            'user' => $user,
            'activeAds' => $activeAds,
            'onModerationAds' => $onModerationAds,
            'rejectedAds' => $rejectedAds,
        ]);
    }

    public function actionGetSettings()
    {
        $user = Yii::$app->user->identity;
        $passwordForm = new PasswordForm();

        $locations = Location::find()->select(['name'])->indexBy('id')->column();

        $this->layout = '@app/views/User/auth/layout';

        return $this->render('@app/views/User/account/settings', [
            'model' => $user,
            'passwordForm' => $passwordForm,
            'locations' => $locations,
        ]);
    }

    public function actionSaveSettings()
    {
        /**
         * @var app/models/User $user
         */
        $user = Yii::$app->user->identity;

        if ($this->request->isPost && $user->load($this->request->post()) && $user->save()) {
            return $this->redirect(['/account/settings']);
        }

        $user->loadDefaultValues();
        $passwordForm = new PasswordForm();
        $locations = Location::find()->select(['name'])->indexBy('id')->column();
        $this->layout = '@app/views/User/auth/layout';

        return $this->render('@app/views/User/account/settings', [
            'model' => $user,
            'passwordForm' => $passwordForm,
            'locations' => $locations,
        ]);
    }

    public function actionSavePassword()
    {
        /**
         * @var app/models/User $user
         */
        $user = Yii::$app->user->identity;
        $passwordForm = new PasswordForm();
        $passwordForm->attributes = $this->request->post('PasswordForm');

        if ($passwordForm->validate()) {
            $user->setPassword($passwordForm->password);
            $user->save(false);
        }

        return $this->redirect(['/account/settings']);
    }
}
