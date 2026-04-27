<?php
/* @var $this yii\web\View */
/* @var $model app\models\BookingPayments */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Booking Payment';
$this->params['breadcrumbs'][] = $this->title;

// Define currency options
$currencies = [
    'UGX' => 'UGX (Ugandan Shilling)',
    'USD' => 'USD (US Dollar)'
];

// Default exchange rate for USD to UGX (can be fetched from API or database)
$usdToUgxRate = 3700; // Example rate, replace with actual current rate

// Payment status options
$paymentStatuses = [
    'pending' => 'Pending',
    'completed' => 'Completed',
    'failed' => 'Failed',
    'refunded' => 'Refunded'
];

// Payment options
$paymentOptions = [
    'cash' => 'Cash',
    'bank_transfer' => 'Bank Transfer',
    'mobile_money' => 'Mobile Money',
    'credit_card' => 'Credit Card'
];

$this->registerJs("
    // Initialize form with current values if they exist
    $(document).ready(function() {
        updateActualAmount();
    });
    
    // Function to update actual amount based on currency and rate
    function updateActualAmount() {
        var currency = $('#bookingpayments-currency').val();
        var amount = parseFloat($('#bookingpayments-amount').val()) || 0;
        var rate = parseFloat($('#bookingpayments-rate').val()) || 1;
        
        if (currency === 'USD') {
            // If USD, multiply by rate to get UGX
            var actualAmount = amount * rate;
            $('#bookingpayments-actual_amount').val(actualAmount.toFixed(2));
        } else {
            // If UGX, actual amount is the same as amount
            $('#bookingpayments-actual_amount').val(amount.toFixed(2));
        }
    }
    
    // Listen for changes on amount, currency and rate fields
    $('#bookingpayments-amount, #bookingpayments-currency, #bookingpayments-rate').on('change keyup', function() {
        updateActualAmount();
    });
    
    // Set default rate when USD is selected
    $('#bookingpayments-currency').on('change', function() {
        if ($(this).val() === 'USD') {
            $('#bookingpayments-rate').val($usdToUgxRate);
            $('.field-bookingpayments-rate').show();
        } else {
            $('#bookingpayments-rate').val(1);
            $('.field-bookingpayments-rate').hide();
        }
        updateActualAmount();
    });
");
?>

<div class="booking-payment-form bg-white p-3">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['id' => 'booking-payment-form']); ?>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'amount')->textInput(['type' => 'number', 'step' => '0.01', 'class' => 'form-control']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'currency')->dropDownList($currencies, [
                        'prompt' => 'Select Currency',
                        'id' => 'bookingpayments-currency',
                    ]) ?>
                </div>
                <div class="col-md-4 field-bookingpayments-rate" style="<?= $model->currency == 'USD' ? '' : 'display:none;' ?>">
                    <?= $form->field($model, 'rate')->textInput([
                        'type' => 'number',
                        'step' => '0.01',
                        'value' => $model->currency == 'USD' ? ($model->rate ?: $usdToUgxRate) : 1
                    ]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'actual_amount')->textInput([
                        'readonly' => true,
                        'class' => 'form-control',
                        'placeholder' => 'Automatically calculated in UGX'
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'paymentOption')->dropDownList($paymentOptions, ['prompt' => 'Select Payment Method']) ?>
                </div>
            </div>

            <div class="form-group text-left">
                <?= Html::submitButton('Save Payment', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
