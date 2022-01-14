<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\UserAd */

$this->title = 'Создание объявления';
$this->params['breadcrumbs'][] = ['label' => 'Мои объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container d-block">

    <div class="new-ad-form">

    <h1 class="text-center mt-4">Подать объявление</h1>

    <?php 
        $errors = $model->getErrors();
        foreach ($errors as $error) {
            echo '<div>' . $error . '</div>' . PHP_EOL;
        }
    ?>

        <?= $this->render('_form', [
            'route' => Url::toRoute(['/ads/create']),
            'model' => $model,
            'currencies' => $currencies,
            'locations' => $locations,
            'categories' => $categories
        ]) ?>

    </div>

</div>