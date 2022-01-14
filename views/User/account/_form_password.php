<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserAd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-update-form">

    <?php $form = ActiveForm::begin(
        [
            'options' => [
                'enctype' => 'multipart/form-data',
            ],
            'action' => $route,
        ]
    ); ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'password_confirmation')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>