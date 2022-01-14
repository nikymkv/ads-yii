<?php

namespace app\modules\admin\controllers;

use app\models\UserAd;
use app\modules\admin\models\UserAdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

/**
 * ModeratorController implements the CRUD actions for UserAd model.
 */
class ModeratorController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'moderate', 'logout'],
                'rules' => [
                    [
                        'actions' => ['index', 'moderate', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->is_admin;
                        }
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
                    'moderate' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserAd models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserAdSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $this->findModel($id)->delete();

        return $this->redirect(['/']);
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

    public function actionModerate(int $id)
    {
        if ($this->request->isPost) {
            $ad = $this->findModel($id);
            $ad->status = $this->request->post('status', $ad->status);
            $ad->save(false);
        }

        return $this->redirect(['/']);
    }
}
