<?php
/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="<?= Url::to(['/web/front/imgs/logo.png']) ?>">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Main Header -->
<header class="main-header">
    <div class="logo d-flex justify-content-between align-items-center">
        <div class="maqam-logo overflow-hidden m-0 p-0">
            <img src="<?= Url::to(['web/images/logo.png']) ?>" alt="Maqam Travels Logo">
        </div>
        <span>Maqam Travels</span>
    </div>
    <button id="navbar-toggle" class="navbar-toggle" type="button" aria-label="Toggle navigation">
        <i class="fa fa-bars"></i>
    </button>

    <div class="user-profile dropdown">
        <span class="dropdown-toggle p-0 m-0 mt-1" type="button" data-bs-toggle="dropdown" aria-expanded="false"
              id="userDropdownMenu">
            <i class="fa fa-user m-0"></i>
        </span>
        <ul class="dropdown-menu dropdown-menu-end bg-primary" aria-labelledby="userDropdownMenu">
            <?php if (!Yii::$app->user->isGuest): ?>
                <li>
                    <div class="dropdown-item-text fw-bold text-white">
                        <?= Yii::$app->user->identity->name ?>
                    </div>
                </li>
                    <li><a class="dropdown-item text-white hover-primary" href="<?= Url::to(['/user/profile']) ?>">
                        <i class="fa fa-id-card fa-sm me-2 text-white hover-primary" style="font-size: small"></i> Profile
                    </a></li>
                <li><?= Html::a(
                        '<i class="fa fa-sign-out-alt text-white fa-sm me-2 hover-primary" style="font-size: small"></i> Logout',
                        ['/site/logout'],
                        ['class' => 'dropdown-item text-white hover-primary', 'data-method' => 'post']
                    ) ?></li>
            <?php else: ?>
                <li><a class="dropdown-item text-white hover-primary" href="<?= Url::to(['/site/login']) ?>">
                        <i class="fa fa-sign-in-alt fa-sm me-2"></i> Login
                    </a></li>
            <?php endif; ?>
        </ul>
<style>
.hover-primary:hover {
    /*color: var(--bs-primary) !important;*/
    background-color: #2782c5 !important;
    font-weight: 500;
}
</style>    </div>

</header>

<div class="wrapper">
    <!-- Sidebar -->
    <?= $this->render('_sidebar') ?>
    <!-- Page Content -->
    <div id="content">
        <!--            <div class="breadcrumb-container">-->
        <!--                --><?php //= Breadcrumbs::widget([
        //                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        //                    'options' => ['class' => 'breadcrumb'],
        //                    'itemTemplate' => "<li class=\"breadcrumb-item\">{link}</li>\n",
        //                    'activeItemTemplate' => "<li class=\"breadcrumb-item active\">{link}</li>\n"
        //                ]) ?>
        <!--            </div>-->
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navbarToggle = document.getElementById('navbar-toggle');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        navbarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
        });
    });
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
