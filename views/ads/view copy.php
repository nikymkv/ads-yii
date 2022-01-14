<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserAd */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'User Ads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-ad-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_id',
            'category_id',
            'subcategory_id',
            'currency_id',
            'location_id',
            'city_id',
            'title',
            'description:ntext',
            'photo_array',
            'price',
            'bargain',
            // 'phone_array',
            'watch_phone',
            'favourites_count',
            'views_count',
            'status',
        ],
    ]) ?>

</div>
