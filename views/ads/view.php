<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\UserAd */

$this->title = $model->title;

\yii\web\YiiAsset::register($this);
?>
<section class="obyava-content">
    <p class="breadcrumbs">
        Все объявления
        <span class="bread-arrow"></span>
        <?php echo $model->category->name ?>
        <span class="bread-arrow"></span>
        <?php echo $model->subCategory->name ?>
    </p>
    <h1><?php echo $model->title ?></h1>
    <?php
        if (is_string($model->photo_array)) {
            $images =  json_decode($model->photo_array);
        } else {
            $images = $model->photo_array;
        }
    ?>
    <?php if ($images !== null && count($images) > 0) { ?>
        <div class="row">
            <?php foreach ($images as $path) { ?>
                <div class="col-lg-3 col-md-4 col-6 thumb">
                    <a data-fancybox="gallery" href="<?php echo Yii::getAlias('@web/' . $path) ?>">
                        <img src="<?php echo Yii::getAlias('@web/' . $path) ?>" alt="<?php echo $model->title ?>" class="img-fluid">
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="obyava-description">
        <h3>Описание</h3>
        <p><?php echo $model->description ?></p>
    </div>

    <div class="obyava-attrs">
        <p>
            <span><?php echo $model->created_at ?></span>
        </p>
    </div>
    <!-- @if($favorite)
        <a class="obyava-favorit"><img src="{{ asset('css/images/icon-star.png') }}" alt="В избранных">В избранных</a>
        @else
        @auth
        <a class="obyava-favorit" onclick="adFavorite({{ $item->id }});"><img src="{{ asset('css/images/icon-star.png') }}" alt="Добавить в избранные">Добавить в избранные</a>
        <a class="obyava-favorit-already"><img src="{{ asset('css/images/icon-star.png') }}" alt="В избранных">В избранных</a>
        @endauth
        @guest
        <a class="obyava-favorit" onclick="favorite();"><img src="{{ asset('css/images/icon-star.png') }}" alt="Добавить в избранные">Добавить в избранные</a>
        @endguest
        @endif -->
</section>

<section class="obyava-sidebar">
    <div class="obyava-seller-wrap">
        <label>Оценка пользователей: <?php echo $model->getAverageRate() ?></label>
        <?php if (Yii::$app->user->isGuest) { ?>
            <p><a href="<?php echo Url::toRoute('/login') ?>">Войдите</a> , чтобы оценить объявление</p>
        <?php } else { ?>
            <div class="form-group">
                <?php if ($model->isRateByUser()) { ?>
                    <label>Ваша оценка - <?php echo $model->getRateByUser() ?></label>
                <?php } ?>
                <div class="star-rating">
                    <div class="star-rating__wrap">
                        <input class="star-rating__input" id="star-5" type="radio" name="rating" value="5">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-5" title="Отлично"></label>
                        <input class="star-rating__input" id="star-4" type="radio" name="rating" value="4">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-4" title="Хорошо"></label>
                        <input class="star-rating__input" id="star-3" type="radio" name="rating" value="3">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-3" title="Удовлетворительно"></label>
                        <input class="star-rating__input" id="star-2" type="radio" name="rating" value="2">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-2" title="Плохо"></label>
                        <input class="star-rating__input" id="star-1" type="radio" name="rating" value="1">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-1" title="Ужасно"></label>
                    </div>
                </div>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'id' => 'rate_ad_btn']) ?>
            </div>
        <?php } ?>
    </div>
    <div class="obyava-price-wrap">
        <p class="obyava-price"><?php echo $model->price ?> <?php echo $model->currency->name ?></p>
        <?php if ($model->bargain) { ?>
            <p class="obyava-price-bagrain">Возможен торг</p>
        <?php } ?>
    </div>
    <div class="obyava-seller-wrap">
        <p class="obyava-seller-ttl">Продавец</p>
        <p class="obyava-seller-name"><a href="#"><?php echo $model->user->name ?></a></p>
        <p class="obyava-seller-ttl mt-30">Местонахождение:</p>
        <p class="obyava-seller-name">
            <?php
            echo $model->user->location ? $model->user->location->name : 'Регион не указан'
            ?> -
            <?php
            echo $model->user->city ? $model->user->city->name : 'Город не указан'
            ?>
        </p>
        <p class="obyava-seller-ttl mt-30">Телефон:</p>
        <?php
        foreach ($model->getPhoneArray() as $phone) {
            echo $phone . '<br>';
        } ?>
        <a href="<?php echo Url::toRoute(['/ads/by-user/' . $model->user_id]) ?>" class="seller-obyava">Все объявления продавца</a>
    </div>
</section>
<script>
    let rateAdBtn = document.querySelector('#rate_ad_btn');
    rateAdBtn.addEventListener('click', rateRequest);

    async function sendPostData(url = '', data = {}) {
        let param = document.querySelector('meta[name=csrf-param]').getAttribute('content')
        let token = document.querySelector('meta[name=csrf-token]').getAttribute('content')

        data[param] = token;

        console.log(data);

        const response = await fetch(url, {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': token
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
            body: JSON.stringify(data)
        });

        return await response.json();
    }

    function rateRequest() {
        let rateRadio = document.querySelector('input[name="rating"]:checked');
        if (rateRadio === null) {
            return;
        }

        sendPostData('<?php echo Url::toRoute('ads/rate') ?>', {
                'ad_id': <?php echo $model->id ?>,
                'rate': rateRadio.value
            })
            .then((data) => {
                console.log('success')
            })
            .catch((err) => {
                console.log(err)
            });
    }
</script>