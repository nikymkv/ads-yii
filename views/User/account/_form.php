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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput() ?>

    <?= $form->field($model, 'location_id')->dropDownList($locations, []) ?>

    <?= $form->field($model, 'city_id')->dropDownList([], []) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    async function getData(url = '') {
        const response = await fetch(url, {
            headers: {
                'Content-Type': 'application/json'
            },
        });

        return await response.json();
    }


    function fillCitiesSelect(e) {
        getData('http://ads-yii.loc/cities/by-location/' + e.target.value)
            .then((data) => {
                let citySelect = document.querySelector('#user-city_id');
                citySelect.length = 0;
                data.forEach((city) => {
                    let opt = document.createElement('option');
                    opt.value = city.id;
                    opt.innerHTML = city.name;
                    if (<?php echo $model->city_id ? $model->city_id : 0 ?> == city.id) {
                        opt.selected = true;
                    }
                    citySelect.appendChild(opt);
                });
            });
    }

    let locationSelect = document.querySelector('#user-location_id');
    locationSelect.addEventListener('change', fillCitiesSelect);

    document.addEventListener("DOMContentLoaded", function(event) {
        const evt = new Event('change');
        locationSelect.dispatchEvent(evt);
    });
</script>