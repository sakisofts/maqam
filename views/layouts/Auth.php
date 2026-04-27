<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
<link rel="icon" type="image/jpg" href="<?= Url::to(['/web/front/imgs/logo.png']) ?>">

<head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style>
            /* Ensure the html and body take up full viewport */
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background: #fff;
            }
            /* Main container for centering content */
            .main-container {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh; /* Use viewport height */
                width: 100%;
                padding: 20px;
                box-sizing: border-box;
            }


            .login-container {
                max-width: 450px;
                width: 100%;
                padding: 20px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .login-title {
                font-size: 24px;
                color: #333;
                margin-bottom: 10px;
            }

            .login-subtitle {
                font-size: 14px;
                color: #666;
            }



            /* Content wrapper to ensure proper centering */
            .content-wrapper {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        </style>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <!-- Main content with proper full viewport centering -->
    <div class="main-container">
        <div class="content-wrapper">
            <?= $content ?>
        </div>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
