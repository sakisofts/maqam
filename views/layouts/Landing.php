<?php /* @var $content string */
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\LandingAssets;
 LandingAssets::register($this);
 $this->title = 'Maqam Travels';
?>
<!DOCTYPE html>
<html lang="en">
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="The sacred journey starts with us, we take you there">
    <meta name="author" content="Kalanzi Ibrahim">
    <link rel="icon" type="image/jpg" href="<?= Url::to(['/web/front/imgs/logo.png']) ?>">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
<?php $this->beginBody() ?>
<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
