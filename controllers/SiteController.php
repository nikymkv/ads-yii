<?php

namespace app\controllers;

use app\filters\AdFilter;
use app\models\Category;
use app\models\Currency;
use app\models\Location;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\UserAd;
use yii\data\ActiveDataFilter;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $filter = new AdFilter($this->request);
        $query = $filter->apply(UserAd::find())->andWhere('status=1');
        $adsCount = clone $query;
        $pages = new Pagination(['totalCount' => $adsCount->count(), 'defaultPageSize' => 10]);
        $orderBy = $this->getOrderBy($this->request->get('sort', 1));

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy($orderBy)
            ->all();

        return $this->render('@app/views/ads/index', [
            'models' => $models,
            'pages' => $pages,
            'filters' => $this->getFilters(),
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->status != 1) {
            throw new \yii\web\NotFoundHttpException('Page not found.');
        }

        $this->layout = '@app/views/ads/layout';
        return $this->render('@app/views/ads/view', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = UserAd::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetAdsByUser(int $id)
    {
        $query = UserAd::find()->where('user_id=:id', [':id' => $id]);
        $adsCount = clone $query;
        $pages = new Pagination(['totalCount' => $adsCount->count(), 'defaultPageSize' => 10]);
        $models = $query->offset($pages->offset)
            ->orderBy('created_at DESC')
            ->limit($pages->limit)
            ->all();

        return $this->render('@app/views/ads/index_by_user', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    protected function getFilters()
    {
        $filters = [];

        $filters['locations'] = Location::find()->select(['id', 'name'])->orderBy('name ASC')->all();
        $filters['categories'] = Category::getWithAdsCount();
        $filters['price'] = ['Все', 'Фиксированная', 'По договоренности'];
        $filters['currencies'] = Currency::find()->select(['id', 'name'])->all();
        $filters['sort'] = [1 => 'Сначала новые', 2 => 'От дешевых к дорогим', 3 => 'От дорогих к дешевым'];

        return $filters;
    }

    protected function getOrderBy($sortIndex)
    {
        if ($sortIndex == 1) {
            return 'created_at DESC';
        } else if ($sortIndex == 2) {
            return 'price ASC';
        } else {
            return 'price DESC';
        }
    }

    public function actionCategoriesStat()
    {
        $query = Category::getWithAdsCount();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('categories', [
            'dataProvider' => $dataProvider
        ]);
    }
}
