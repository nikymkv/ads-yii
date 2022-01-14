<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Moderator\UserAdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Панель модератора';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row justify-content-center align-items-center">
    <div class="col-1"></div>
    <div class="col">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'title',
                [
                    'attribute' => 'Категория',
                    'value' => 'category.name',
                ],
                [
                    'attribute' => 'Создано',
                    'value' => 'created_at',
                ],
                [
                    'class' => 'yii\grid\DataColumn',
                    'attribute' => 'Цена',
                    'value' => function ($data) {
                        $value = $data->price . ' ' . $data->currency->name;
                        $value .= $data->bargain ? ' (торг)' : '';
                        return $value;
                    },
                ],
                [
                    'attribute' => 'Пользователь',
                    'value' => 'user.name',
                ],
                [
                    'class' => 'yii\grid\DataColumn',
                    'attribute' => 'Статус',
                    'value' => function ($data) {
                        if ($data->status == 1) {
                            return 'Опубликовано';
                        } else if ($data->status == 2) {
                            return 'На модерации';
                        } else if ($data->status == 3) {
                            return 'Отклонено';
                        }
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{applyBtn}<br>{denyBtn}',
                    'buttons' => [
                        'applyBtn' => function ($url, $model, $key) {
                            $link = 'http://admin.ads-yii.loc/ads/' . $model->id . '/moderate';
                            return Html::a('Принять', $link, [
                                'class' => 'btn-sm btn-primary',
                                'data-method' => 'POST',
                                'data-params' => [
                                    'status' => 1
                                ]
                            ]);
                        },
                        'denyBtn' => function ($url, $model, $key) {
                            $link = 'http://admin.ads-yii.loc/ads/' . $model->id . '/moderate';
                            return Html::a('Отклонить', $link, [
                                'class' => 'btn-sm btn-primary',
                                'data-method' => 'POST',
                                'data-params' => [
                                    'status' => 3
                                ]
                            ]);
                        },
                    ]
                ]
            ]
        ]) ?>
    </div>
    <div class="col-1"></div>
</div>