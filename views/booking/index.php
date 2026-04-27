<?php
use app\components\Generics\FlashAlertWidget;
use app\components\Generics\TableGenerator;
use app\widgets\PageHeaderWidget;

$this->title = "Booking - ".yii::$app->name;

/**
 * @var $search \app\models\BookingSearch
 * @var $model \app\models\BookingSearch
 * @var $provider \yii\data\ActiveDataProvider
 * @var $export \app\models\Bookings
 * @var $searchFields \app\models\BookingSearch
 */

?>
<div class="contain-fluid bg-white p-4">
    <?= FlashAlertWidget::widget([
        'duration' => 5000,
        'position' => 'top-right',
        'showCloseButton' => true
    ]) ?>
    <?= PageHeaderWidget::widget([
        'page' => 'All Bookings',
        'export_model' => $export,
        'searchFields' => $searchFields,
        'model' => $search,
        'additional_buttons' => [
            [    'url' => 'place-booking',
                'label' => 'Place Booking',
                'icon' => 'fas fa-plus ',
                'options' => [
                    'class' => 'btn btn-primary',
                    'id' => 'import-btn'
                ]
            ]
        ]
    ]) ?>
    <div class="row">
        <div class="col-12">
            <?=TableGenerator::table($search, $model, $provider); ?>
        </div>
    </div>
</div>
