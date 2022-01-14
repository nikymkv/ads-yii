<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Вход';
?>
<div class="container d-block">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Вход</div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'template' => "{label}<div class=\"col-md-6\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                            'labelOptions' => ['class' => 'col-md-4 col-form-label text-md-right'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label('Email') ?>

                    <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\"col-md-6 offset-md-4\"><div class=\"form-check\">{input}{label}</div></div>\n<div class=\"col-lg-8\">
                                {error}
                            </div>",
                        'class' => 'form-check-input',
                        'labelOptions' => [
                            'class' => 'form-check-label',
                            'checked' => false,
                            'value' => 0,
                        ],
                    ])->label('Запомнить меня') ?>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>