<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Регистрация';
?>
<div class="container d-block">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Регистрация</div>

                <div class="card-body">

                    <?php $form = ActiveForm::begin([
                        'id' => 'register-form',
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-md-6\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                            'labelOptions' => ['class' => 'col-md-4 col-form-label text-md-right'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label('Ваше имя') ?>

                    <?= $form->field($model, 'email')->textInput()->label('Ваша почта') ?>

                    <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

                    <?= $form->field($model, 'password_confirmation')->passwordInput()->label('Повторите пароль') ?>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>