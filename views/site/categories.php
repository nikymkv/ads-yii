<?php
 use yii\grid\GridView;
 use yii\helpers\Html;

$this->title = 'Статистика по категориям';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row justify-content-center align-items-center">
    <div class="col-1"></div>
    <div class="col">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'ID',
                    'value' => 'id'
                ],
                [
                    'attribute' => 'Название',
                    'value' => 'name'
                ],
                [
                    'attribute' => 'Количество объявлений',
                    'value' => 'ads_count'
                ],
            ]
        ]) ?>
    </div>
    <div class="col-1"></div>
</div>
