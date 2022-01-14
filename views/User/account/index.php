<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Личный кабинет';
?>
<div class="container d-block">
    <section class="acc-header">
        <h1><?php echo $user->name ?></h1>
        <p>откуда - <span>
                <?php if ($user->city) { ?>
                    <?php echo $user->city->name ?>
                <?php } else { ?>
                    Город не указан
                <?php } ?>
            </span></p>
        <p>телефон - <span><?php echo $user->phone ? $user->phone : 'Не указан'  ?></span></p>
        <p>e-mail - <span><?php echo $user->email ?></span></p>
    </section>
    <nav class="main-nav mt-4">
        <ul>
            <li class="acc-nav-item"><a href="<?php echo Url::toRoute(['/account']) ?>" class="acc-active-page">Мои объявления</a></li>
            <li class="acc-nav-item"><a href="<?php echo Url::toRoute(['/account/settings']) ?>">Настройки</a></li>
        </ul>
    </nav>

    <div class="obyava-add-wrap">
        <a href="<?php echo Url::toRoute(['/ads/create']) ?>">
            <button class="obyava-add">
                <img src="<?php echo Yii::getAlias('@web/images/icon-add.png') ?>" alt="Создать объявление">
                Создать объявление
            </button>
        </a>
    </div>

    <div class="obyava-tabs-wrap">
        <button class="obyava-tabs-toggle obyava-tabs-active" id="tab-active-btn" onclick="adsTabs('active');">Активные - <span><?php echo count($activeAds) ?></span></button>
        <button class="obyava-tabs-toggle" id="tab-moder-btn" onclick="adsTabs('moder');">На модерации - <span><?php echo count($onModerationAds) ?></span></button>

        <?php if (count($rejectedAds)) { ?>
            <button class="obyava-tabs-toggle" id="tab-rejected-btn" onclick="adsTabs('rejected');">Отклоненные - <span><?php echo count($rejectedAds) ?></span></button>
        <?php } ?>
    </div>
    <section class="acc-obyava" id="acc-obyava-active">
        <?php if (count($activeAds)) { ?>
            <?php foreach ($activeAds as $item) { ?>
                <article class="acc-obyava-items">
                    <div class="acc-obyava-item">
                        <a href="<?php echo Url::toRoute(['/' . $item->id]) ?>">
                            <div class="d-flex">
                                <div class="obyava-rows-icon-wrap">
                                    <img src="<?php echo count($item->getPhotoArray() ?? [])
                                                    ? Yii::getAlias('@web/' . $item->getPhotoArray()[0])
                                                    : Yii::getAlias('@web/images/noimage.png') ?>" alt="<?php echo $item->title ?>" class="obyava-rows-icon">
                                </div>
                                <div class="obyava-rows-title">
                                    <h5><?php echo $item->title ?></h5>
                                    <p><?php echo $item->category->name ?> &gt; <?php echo $item->subCategory->name ?></p>
                                    <p class="obyava-rows-date"><?php echo $item->created_at ?></p>
                                </div>
                                <div class="obyava-rows-price">
                                    <?php echo $item->price ?> <?php echo $item->currency->name ?></p>
                                    <?php if ($item->bargain) { ?>
                                        <p>Возможен торг</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="acc-obyava-options">
                        <button class="option-edit" onclick="window.location.href='<?php echo Url::toRoute(['/ads/' . $item->id . '/edit']) ?>'"><img src="<?php echo Yii::getAlias('@web/images/icon-edit.png') ?>" alt="Редактировать объявление">Редактировать</button>
                        <button class="option-delete" onclick="modalDeleteSelfAd( <?php echo $item->id ?> );"><img src="<?php echo Yii::getAlias('@web/images/icon-delete.png') ?>" alt="Удалить объявление">Удалить</button>
                    </div>
                </article>
            <?php } ?>
        <?php } else { ?>
            <article class="acc-obyava-empty">
                <h5>Активных объявлений нет</h5>
            </article>
        <?php } ?>
    </section>

    <section class="acc-obyava d-none" id="acc-obyava-moder">
        <?php if (count($onModerationAds)) { ?>
            <?php foreach ($onModerationAds as $item) { ?>
                <article class="acc-obyava-items">
                    <div class="acc-obyava-item">
                        <a href="<?php Url::toRoute(['/' . $item->id]) ?>">
                            <div class="d-flex">
                                <div class="obyava-rows-icon-wrap">
                                    <img src="<?php echo count($item->getPhotoArray() ?? [])
                                                    ? Yii::getAlias('@web/' . $item->getPhotoArray()[0])
                                                    : Yii::getAlias('@web/images/noimage.png') ?>" alt="<?php echo $item->title ?>" class="obyava-rows-icon">
                                </div>
                                <div class="obyava-rows-title">
                                    <h5><?php echo $item->title ?></h5>
                                    <p><?php echo $item->category->name ?> &gt; <?php echo $item->subCategory->name ?></p>
                                    <p class="obyava-rows-date"><?php echo $item->created_at ?></p>
                                </div>
                                <div class="obyava-rows-price">
                                    <?php echo $item->price ?> <?php echo $item->currency->name ?></p>
                                    <?php if ($item->bargain) { ?>
                                        <p>Возможен торг</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="acc-obyava-options">
                        <button class="option-edit" onclick="window.location.href='<?php echo Url::toRoute(['/ads/' . $item->id . '/edit']) ?>'"><img src="<?php echo Yii::getAlias('@web/images/icon-edit.png') ?>" alt="Редактировать объявление">Редактировать</button>
                        <button class="option-delete" onclick="modalDeleteSelfAd( <?php echo $item->id ?> );"><img src="<?php echo Yii::getAlias('@web/images/icon-delete.png') ?>" alt="Удалить объявление">Удалить</button>
                    </div>
                </article>
            <?php } ?>
        <?php } else { ?>
            <article class="acc-obyava-empty">
                <h5>На модерации объявлений нет</h5>
            </article>
        <?php } ?>
    </section>

    <?php if (count($rejectedAds)) { ?>
        <section class="acc-obyava d-none" id="acc-obyava-rejected">
            <?php foreach ($rejectedAds as $item) { ?>
                <article class="acc-obyava-items">
                    <div class="acc-obyava-item">
                        <a href="<?php Url::toRoute(['/' . $item->id]) ?>">
                            <div class="d-flex">
                                <div class="obyava-rows-icon-wrap">
                                    <img src="<?php echo count($item->getPhotoArray() ?? [])
                                                    ? Yii::getAlias('@web/' . $item->getPhotoArray()[0])
                                                    : Yii::getAlias('@web/images/noimage.png') ?>" alt="<?php echo $item->title ?>" class="obyava-rows-icon">
                                </div>
                                <div class="obyava-rows-title">
                                    <h5><?php echo $item->title ?></h5>
                                    <p><?php echo $item->category->name ?> &gt; <?php echo $item->subCategory->name ?></p>
                                    <p class="obyava-rows-date"><?php echo $item->created_at ?></p>
                                </div>
                                <div class="obyava-rows-price">
                                    <?php echo $item->price ?> <?php echo $item->currency->name ?></p>
                                    <?php if ($item->bargain) { ?>
                                        <p>Возможен торг</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="acc-obyava-options">
                        <button class="option-edit" onclick="window.location.href='<?php echo Url::toRoute(['/ads/' . $item->id . '/edit']) ?>'"><img src="<?php echo Yii::getAlias('@web/images/icon-edit.png') ?>" alt="Редактировать объявление">Редактировать</button>
                        <button class="option-delete" onclick="modalDeleteSelfAd( <?php echo $item->id ?> );"><img src="<?php echo Yii::getAlias('@web/images/icon-delete.png') ?>" alt="Удалить объявление">Удалить</button>
                    </div>
                </article>
            <?php } ?>
        </section>
    <?php } ?>

    <div class="delete-self-ad-modal">
        <button onclick="closeModal(this);"><img src="{{ asset('/css/images/icon-delete.png') }}" alt="Закрыть"></button>
        <h3>Вы уверены, что хотите удалить объявление?</h3>
        <div class="modal-btns-wrap">
            <form action="" method="POST">
                @csrf
                @method('delete')
                <button class="modal-delete">Удалить</button>
            </form>
            <button class="modal-cancel" onclick="cancelModal(this);">Отмена</button>
        </div>
    </div>
</div>

<script>
    function adsTabs(name) {
        let active = document.getElementById('tab-active-btn');
        let moder = document.getElementById('tab-moder-btn');
        let re = document.getElementById('tab-rejected-btn');
        let act_tab = document.getElementById('acc-obyava-active');
        let moder_tab = document.getElementById('acc-obyava-moder');
        let re_tab = document.getElementById('acc-obyava-rejected');
        let target_btn = document.getElementById('tab-' + name + '-btn');
        let target_section = document.getElementById('acc-obyava-' + name);

        active.classList.remove("obyava-tabs-active");
        moder.classList.remove("obyava-tabs-active");
        if ($('#tab-rejected-btn').length > 0) {
            re.classList.remove("obyava-tabs-active");
        }

        act_tab.classList.add("d-none");
        moder_tab.classList.add("d-none");

        if ($('#tab-rejected-btn').length > 0) {
            re_tab.classList.add("d-none");
        }

        target_btn.classList.add("obyava-tabs-active");
        target_section.classList.remove("d-none");
    }
</script>