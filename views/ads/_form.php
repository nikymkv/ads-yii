<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserAd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-ad-form">

    <?php $form = ActiveForm::begin(
        [
            'options' => [
                'enctype' => 'multipart/form-data',
            ],
            'action' => $route,
        ]
    ); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categories, []) ?>

    <?= $form->field($model, 'subcategory_id')->dropDownList([], []) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'photo_array[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <?php if (count($model->getPhotoArray())) { ?>
        <div class="row">
            <?php foreach ($model->getPhotoArray() as $path) { ?>
                <div class="col-lg-3 col-md-4 col-6 thumb">
                    <a data-fancybox="gallery" href="<?php echo Yii::getAlias('@web/' . $path) ?>">
                        <img src="<?php echo Yii::getAlias('@web/' . $path) ?>" alt="<?php echo $model->title ?>" class="img-fluid">
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_id')->dropDownList($currencies, []) ?>

    <?= $form->field($model, 'bargain')->checkbox() ?>

    <?= $form->field($model, 'location_id')->dropDownList($locations, []) ?>

    <?= $form->field($model, 'city_id')->dropDownList([], []) ?>

    <?= $form->field($model, 'phone_array[0]')->textInput()->label('Телефон №1') ?>

    <?= $form->field($model, 'phone_array[1]')->textInput()->label('Телефон №2') ?>

    <?= $form->field($model, 'phone_array[2]')->textInput()->label('Телефон №3') ?>

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
                let citySelect = document.querySelector('#userad-city_id');
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

    function fillSubCategoriesSelect(e) {
        getData('http://ads-yii.loc/subcategories/by-category/' + e.target.value)
            .then((data) => {
                let subCategorySelect = document.querySelector('#userad-subcategory_id')
                subCategorySelect.length = 0;
                data.forEach((subCategory) => {
                    let opt = document.createElement('option');
                    opt.value = subCategory.id;
                    opt.innerHTML = subCategory.name;
                    if (<?php echo $model->subcategory_id ? $model->subcategory_id : 0 ?> == subCategory.id) {
                        opt.selected = true;
                    }
                    subCategorySelect.appendChild(opt);
                });
            })
    }

    let locationSelect = document.querySelector('#userad-location_id');
    locationSelect.addEventListener('change', fillCitiesSelect);

    let categorySelect = document.querySelector('#userad-category_id');
    categorySelect.addEventListener('change', fillSubCategoriesSelect);
    document.addEventListener("DOMContentLoaded", function(event) {
        const evt = new Event('change');
        categorySelect.dispatchEvent(evt);
        locationSelect.dispatchEvent(evt);
    });
</script>