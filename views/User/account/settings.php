<?php

use yii\helpers\Url;
?>
<div class="container d-block">
    <nav class="main-nav mt-4">
        <ul>
            <li class="acc-nav-item"><a href="<?php echo Url::toRoute(['/account']) ?>">Мои объявления</a></li>
            <li class="acc-nav-item"><a class="acc-active-page" href="<?php echo Url::toRoute(['/account/settings']) ?>">Настройки</a></li>
        </ul>
    </nav>
    <div>
        <h2 class="text-center mt-4">Настройки профиля</h2>
    </div>

    <div class="new-ad-form">
        <?= $this->render('_form', [
            'route' => Url::toRoute(['/account/settings']),
            'model' => $model,
            'locations' => $locations,
        ]) ?>
    </div>

    <div class="mt-4 pt-4">
        <h2 class="text-center">Смена пароля</h2>
    </div>

    <div class="new-ad-form">
        <?= $this->render('_form_password', [
            'route' => Url::toRoute(['/account/settings/password']),
            'model' => $passwordForm,
        ]) ?>
    </div>

</div>