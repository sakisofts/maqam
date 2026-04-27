<?php

use app\components\Generics\CrossHelper;
use app\models\MasterPackage;
use app\widgets\SearchableDropDown;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Reservation */
/* @var $form yii\bootstrap5\ActiveForm */

const SELECT_CLIENT = 'Select Client';
$this->title = $model->isNewRecord ? 'Create Reservation' : 'Update Reservation: ' . $model->reservation_number;
// Get user and package data for dropdowns
?>

<div class="container-fluid bg-white p-3 reservation-form">
    <h1 class="mb-4 mt-3"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'reservation-form',
        'options' => ['class' => 'needs-validation'],
    ]); ?>

    <div class="row mb-3">
        <div class="col-md-4">
            <?= $form->field($model, 'reservation_number')
                ->textInput(['maxlength' => true, 'readonly' => !$model->isNewRecord])->label('RSV.No') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'user_id')->widget(SearchableDropDown::class,
                [
                    'data' => ArrayHelper::map(CrossHelper::customers(),'id','name'),
                    'placeholder' => SELECT_CLIENT,
                    'options' => ['class' => 'form-control h-100 select2-search', 'placeholder' => 'Select Client'],
            ])->label('Select Client') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'number_of_pilgrims')->textInput(['type' => 'number', 'min' => 1]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'package_id')->widget(SearchableDropDown::class, [
                 'data'=>ArrayHelper::map(CrossHelper::mPackages(),'id','package_name'),
                'placeholder' => 'Select Package',
                'class' => 'form-select',
            ])->label('Select Package') ?>
        </div>


        <div class="col-md-4">
            <?= $form->field($model, 'total_amount')->textInput(['type' => 'number', 'step' => '0.01', 'min' => '0']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'amount_paid')->textInput(['type' => 'number', 'step' => '0.01', 'min' => '0']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'balance_due')->textInput(['type' => 'number', 'step' => '0.01', 'min' => '0', 'readonly' => true]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'payment_deadline')->widget(DatePicker::class, [
                'language' => 'en',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control'],
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                    'yearRange' => '-0:+2',
                ],
            ]) ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'special_requests')->textarea(['rows' => 3, 'class' => 'form-control']) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Cancel', ['reserve'], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <?php
    $url = Url::to(['get-price']);
    $js = <<<JS

$('[name="Reservation[package_id]"]').on('change', function() {
    var packageId = $(this).val();
    console.log(packageId)
    if (packageId) {
        $.post(`{$url}`, 
            {id: packageId}, 
            function(response) {
                if (response.success && response.price) {
                    var pilgrims = parseInt($('#reservation-number_of_pilgrims').val()) || 1;
                    if (pilgrims > 1) {
                        $('#reservation-total_amount').val((response.price * pilgrims).toFixed(2)).trigger('change');
                    }else {
                    $('#reservation-total_amount').val(response.price).trigger('change');
                    }
                }
            }, 
            'json'
        ).fail(function(xhr) {
            console.error('Error fetching package price:', xhr.responseText);
        });
    }
});

// Auto-calculate balance due when total amount or amount paid changes
$('#reservation-total_amount, #reservation-amount_paid').on('change keyup', function() {
    var totalAmount = parseFloat($('#reservation-total_amount').val()) || 0;
    var amountPaid = parseFloat($('#reservation-amount_paid').val()) || 0;
    var balanceDue = totalAmount - amountPaid;
    $('#reservation-balance_due').val(balanceDue.toFixed(2));
});


// Generate reservation number when creating new record
if ($('#reservation-reservation_number').val() === '') {
    var prefix = 'RES-';
    var timestamp = new Date().getTime().toString().slice(-8);
    var random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
    $('#reservation-reservation_number').val(prefix + timestamp + '-' + random);
}
$('#reservation-number_of_pilgrims').data('last-value', parseInt($('#reservation-number_of_pilgrims').val()) || 1);

JS;

    $this->registerJs($js);
    ?>
