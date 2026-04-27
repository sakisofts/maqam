<?php
/* @var $this yii\web\View */
/* @var $model app\models\BookingPayments */

use yii\helpers\Html;
$this->title = 'Create Booking Payment';
?>
<div class="booking-payments-create">
    <?= $this->render('_payForm', [
        'model' => $model,
    ]) ?>
</div>
