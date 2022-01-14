<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap4\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <nav class="navbar navbar-expand-md bg-main p-0">
        <div class="container">
            <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <?php if (Yii::$app->user->isGuest) { ?>
                        <li class="nav-item">
                            <a class="nav-link nav-link-white" href="<?php echo Url::toRoute('/login') ?>">Вход</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-white" href="<?php echo Url::toRoute('/register') ?>">Регистрация</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link nav-link-white dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <?php echo Yii::$app->user->identity->name ?><span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo Url::toRoute(['/account']) ?>">Личный кабинет</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Выйти
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <header class="mt-4">
        <div class="header-wrap">
            <div class="logo">
                <a href="/">
                    <img src="<?php echo Yii::getAlias('@web/' . 'images/logo.png') ?>" alt="Енакиево сити">
                </a>
            </div>
            <div class="social-menu">
                <div class="social-menu-item social-menu-item-1">
                    <a href="https://vk.com/enakievo.city" target="_blank">
                        <img src="<?php echo Yii::getAlias('@web/' . 'images/icon-vk.png') ?>" alt="Enakievo.city ВКонтакте доска объявлений">
                    </a>
                </div>
                <div class="social-menu-item social-menu-item-2">
                    <a href="https://www.facebook.com/EnakievoCity" target="_blank">
                        <img src="<?php echo Yii::getAlias('@web/' . 'images/icon-facebook.png') ?>" alt="Enakievo.city в Фейсбук доска объявлени">
                    </a>
                </div>
                <div class="social-menu-item social-menu-item-3">
                    <a href="https://ok.ru/group/58979137159415" target="_blank">
                        <img src="<?php echo Yii::getAlias('@web/' . 'images/icon-odnoklassniki.png') ?>" alt="nakievo.city в Одноклассниках доска объявлени">
                    </a>
                </div>
                <div class="social-menu-item social-menu-item-4">
                    <a href="https://t.me/EnakievoCity" target="_blank">
                        <img src="<?php echo Yii::getAlias('@web/' . 'images/icon-telegram.png') ?>" alt="nakievo.city в Телеграм доска объявлени">
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="py-4">

        <div class="ad-container">

            <?php echo $content ?>

        </div>

    </main>

    <footer>
        <div class="footer-wrap">

            <a class="back_to_top" id="back_to_top" title="Наверх"><span class="top-arrow"></span>Наверх</a>

            <div class="footer-left">

                <a href="/">
                    <img src="<?php echo Yii::getAlias('@web/images/logo-inverted.png') ?>" width="200px">
                </a>

                <p>&copy; <?php echo date('Y') ?>. Все права защищены.</p>

                <p>Частичное или полное использование материалов сайта разрешается при условии прямой открытой для поисковых систем ссылки непосредственно на соответствующую страницу сайта <a href="/">Enakievo.city</a></p>

            </div>

            <div class="footer-right">

                <p>Контакты:</p>

                <p><a href="mailto:sales@enakievo.city">sales@enakievo.city</a> - по вопросам размещения рекламы</p>

                <p><a href="mailto:help@enakievo.city">help@enakievo.city</a> - по общим вопросам</p>

            </div>

        </div>

    </footer>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>