<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Все объявления';

?>
<div class="user-ad-index">
    <section class="obyava-all-filters">
        <form action="<?php echo Url::toRoute(['/']) ?>" method="get">
            <div class="row">
                <div class="col">
                    <div>
                        <p>Местоположение</p>
                        <select id="obyava-filter-location" name="location">
                            <option value="0">Все</option>
                            <?php foreach ($filters['locations'] as $location) { ?>
                                <option value="<?php echo $location->id ?>" <?php echo $location->id == Yii::$app->request->get('location') ? 'selected' : '' ?>>
                                    <?php echo $location->name ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <p>Город</p>
                        <select id="obyava-filter-city" name="city">
                            <option value="0">Все</option>
                        </select>
                    </div>

                    <div>
                        <p>Категория</p>
                        <select id="obyava-filter-category" name="category">
                            <option value="0">Все</option>
                            <?php foreach ($filters['categories'] as $category) { ?>
                                <option value="<?php echo $category->id ?>" <?php echo $category->id == Yii::$app->request->get('category') ? 'selected' : '' ?>>
                                    <?php echo $category->name ?> (<?php echo $category->ads_count ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <p>Подкатегория</p>
                        <select id="obyava-filter-subcategory" name="subcategory">
                            <option value="0">Все</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <p>Цена</p>
                        <select id="obyava-filter-price" class="filter-currency" name="price">
                            <?php foreach ($filters['price'] as $key => $price) { ?>
                                <option value="<?php echo $key ?>" <?php echo $key == Yii::$app->request->get('price') ? 'selected' : '' ?>><?php echo $price ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <p>Валюта</p>
                        <select id="obyava-filter-currency" name="currency" class="filter-currency">
                            <option value="0">Все</option>
                            <?php foreach ($filters['currencies'] as $currency) { ?>
                                <option value="<?php echo $currency->id ?>" <?php echo $currency->id == Yii::$app->request->get('currency') ? 'selected' : '' ?>><?php echo $currency->name ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <p>Сортировать</p>
                        <select id="obyava-filter-sort" name="sort">
                            <?php foreach ($filters['sort'] as $key => $sort) { ?>
                                <option value="<?php echo $key ?>" <?php echo $key == Yii::$app->request->get('sort') ? 'selected' : '' ?>><?php echo $sort ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="text-center">
                        <button id="apply-filters" type="submit" class="btn btn-primary mt-4">Применить</button>

                    </div>
                </div>
            </div>
        </form>
        <a href="<?php echo Url::toRoute(['/']); ?>"><button class="btn btn-danger mt-4">Сбросить</button></a>
    </section>


    <?php foreach ($models as $model) { ?>
        <article class="obyava-rows-items">
            <a href="<?php echo Url::toRoute(['site/view', 'id' => $model->id]) ?>">
                <div class="d-flex">
                    <div class="obyava-rows-icon-wrap">
                        <img src="<?php echo count($model->getPhotoArray() ?? [])
                                        ? Yii::getAlias('@web/' . $model->getPhotoArray()[0])
                                        : Yii::getAlias('@web/images/noimage.png') ?>" alt="<?php echo $model->title ?>" class="obyava-rows-icon">
                    </div>
                    <div class="obyava-rows-title">
                        <h5><?php echo $model->title ?></h5>
                        <p><?php echo $model->category->name ?> > <?php echo $model->subCategory->name ?></p>
                        <p class="obyava-rows-date"><?php echo $model->created_at ?></p>
                    </div>
                    <div class="obyava-rows-price">
                        <?php echo $model->price ?> <?php echo $model->currency->name ?></p>
                        <?php if ($model->bargain) { ?>
                            <p>Возможен торг</p>
                        <?php } ?>
                    </div>
                </div>
            </a>
        </article>
    <?php } ?>

    <section class="pagination">
        <div class="pagination-wrap">
            <?php echo LinkPager::widget([
                'pagination' => $pages,
                'prevPageLabel' => false,
                'nextPageLabel' => false,
                // 'activePageCssClass' => 'pagination-btn pagination-btn-active',
                'linkOptions' => ['class' => 'pagination-btn'],
                'maxButtonCount' => 3,
            ]); ?>
        </div>
    </section>

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
                let citySelect = document.querySelector('#obyava-filter-city');
                citySelect.length = 1;
                data.forEach((city) => {
                    let opt = document.createElement('option');
                    opt.value = city.id;
                    opt.innerHTML = city.name;
                    if (<?php echo Yii::$app->request->get('city', 0) ?> == city.id) {
                        console.log('city');
                        opt.selected = true;
                    }
                    citySelect.appendChild(opt);
                });
            });
    }

    function fillSubCategoriesSelect(e) {
        getData('http://ads-yii.loc/subcategories/by-category/' + e.target.value)
            .then((data) => {
                let subCategorySelect = document.querySelector('#obyava-filter-subcategory')
                subCategorySelect.length = 1;
                data.forEach((subCategory) => {
                    let opt = document.createElement('option');
                    opt.value = subCategory.id;
                    opt.innerHTML = subCategory.name;
                    if (<?php echo Yii::$app->request->get('subcategory', 0) ?> == subCategory.id) {
                        console.log('subCategory');
                        opt.selected = true;
                    }
                    subCategorySelect.appendChild(opt);
                });
            })
    }

    let locationSelect = document.querySelector('#obyava-filter-location');
    locationSelect.addEventListener('change', fillCitiesSelect);

    let categorySelect = document.querySelector('#obyava-filter-category');
    categorySelect.addEventListener('change', fillSubCategoriesSelect);
    document.addEventListener("DOMContentLoaded", function(event) {
        const evt = new Event('change');
        categorySelect.dispatchEvent(evt);
        locationSelect.dispatchEvent(evt);
    });
</script>