<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
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
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <nav class="navbar navbar-expand-md bg-main p-0">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="<?php echo Yii::getAlias('@web/' . 'images/logo-inverted.png') ?>" alt="Доска объявлений Enakievo.city" class="acc-logo">
            </a>
            <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <?php if (Yii::$app->user->isGuest) { ?>
                        <li class="nav-item">
                            <a class="nav-link nav-link-white" href="<?php echo Url::toRoute('/login') ?>">Вход</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link nav-link-white dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><?php echo Yii::$app->user->identity->name ?><span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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

    <main class="py-4">

        <?php echo $content ?>

    </main>

    <footer>

        <div class="footer-wrap">

            <a class="back_to_top" id="back_to_top" title="Наверх"><span class="top-arrow"></span>Наверх</a>

            <div class="footer-left">

                <a href="/">
                    <img src="<?php echo Yii::getAlias('@web/' . 'images/logo-inverted.png') ?>" alt="Енакиево сити" class="footer-logo">
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