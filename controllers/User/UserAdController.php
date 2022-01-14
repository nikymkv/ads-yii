<?php

namespace app\controllers\User;

use app\models\Currency;
use app\models\Location;
use app\models\Category;
use app\models\UserAd;
use app\models\UserAdRate;
use Yii;
use yii\base\DynamicModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * UserAdController implements the CRUD actions for UserAd model.
 */
class UserAdController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'edit', 'update', 'delete', 'rate'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'edit', 'update', 'delete', 'rate'],
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

    /**
     * Creates a new UserAd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $userAd = new UserAd();

        if ($this->request->isPost) {
            $data = $this->request->post();
            $data['UserAd']['user_id'] = Yii::$app->user->identity->id;
            $data['UserAd']['status'] = 2;
            $userAd->load($data);
            $images = UploadedFile::getInstances($userAd, 'photo_array');
            $userAd->setImagesPath($images);
            if ($userAd->save()) {
                $url = Url::toRoute(['/account']);
                return $this->redirect($url);
            }
        } else {
            $userAd->loadDefaultValues();
        }

        $currencies = Currency::find()->select(['name'])->indexBy('id')->column();
        $locations = Location::find()->select(['name'])->indexBy('id')->column();
        $categories = Category::find()->select(['name'])->where('parent_id IS NULL')->indexBy('id')->column();

        $this->layout = '@app/views/User/auth/layout';
        return $this->render('@app/views/ads/create', [
            'model' => $userAd,
            'currencies' => $currencies,
            'locations' => $locations,
            'categories' => $categories,
        ]);
    }

    public function actionEdit(int $id)
    {
        $model = $this->findModel($id);

        if (! $this->isOwner($model)) {
            return $this->redirect(['/']);
        }

        $currencies = Currency::find()->select(['name'])->indexBy('id')->column();
        $locations = Location::find()->select(['name'])->indexBy('id')->column();
        $categories = Category::find()->select(['name'])->where('parent_id IS NULL')->indexBy('id')->column();

        $this->layout = '@app/views/User/auth/layout';

        return $this->render('@app/views/ads/update', [
            'model' => $model,
            'currencies' => $currencies,
            'locations' => $locations,
            'categories' => $categories,
        ]);
    }

    /**
     * Updates an existing UserAd model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (! $this->isOwner($model)) {
            return $this->redirect(['/']);
        }

        if (!$this->request->isPost) {
            return $this->render('@app/views/ads/update', [
                'model' => $model,
            ]);
        }

        $images = UploadedFile::getInstances($model, 'photo_array');
        $isLoad = $model->load($this->request->post());
        $model->setImagesPath($images);
        $model->status = 2;

        if ($isLoad && $model->save()) {
            return $this->redirect(['/account' . $model->id]);
        }

        return $this->render('@app/views/ads/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserAd model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (! $this->isOwner($model)) {
            return $this->redirect(['/']);
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserAd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserAd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserAd::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function isOwner(UserAd $userAd)
    {
        $user = Yii::$app->user->identity;

        return $userAd->user_id == $user->id;
    }

    public function actionRate()
    {
        $data = $this->request->post();

        $model = DynamicModel::validateData($data, [
            ['ad_id', 'integer'],
            ['rate', 'double']
        ]);

        if ($model->hasErrors()) {
            return $this->asJson([
                'success' => 0,
                'error_msg' => $model->getErrors()
            ]);
        }

        $userId = Yii::$app->user->identity->id;
        $userAdRate = UserAdRate::find()
            ->where(
                'user_id=:user_id and ad_id=:ad_id',
                [':user_id' => $userId, ':ad_id' => $data['ad_id']]
            )
            ->one();

        if ($userAdRate) {
            $userAdRate->rate = $data['rate'];
            $userAdRate->save(false);

            return $this->asJson([
                'success' => 1
            ]);
        }

        $userAdRate = new UserAdRate();
        $userAdRate->ad_id = $data['ad_id'];
        $userAdRate->user_id = $userId;
        $userAdRate->rate = $data['rate'];
        $userAdRate->save(false);

        return $this->asJson(['success' => 1]);
    }
}
