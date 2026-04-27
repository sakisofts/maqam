<?php

use app\components\Generics\FlashAlertWidget;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use app\models\Payment;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $form yii\bootstrap5\ActiveForm */
/**
 * @var $title string
 * @var $type string
 * @var $payable int;
 */

$this->title = 'New Payment';
?>
<?= FlashAlertWidget::widget([
    'duration' => 5000,
    'position' => 'top-right',
    'showCloseButton' => true
]) ?>

    <div class="payment-create bg-white p-3 rounded">
        <h2><?= Html::encode($this->title).' For '.$title ?></h2>

        <div class="row mt-4">
            <div class="col-md-8">
                <?php $form = ActiveForm::begin(['id' => 'payment-form']); ?>

                <!-- Currency Conversion Control -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Currency Conversion Settings</h5>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enable-custom-conversion">
                            <label class="form-check-label text-white" for="enable-custom-conversion">Enable Custom Conversion</label>
                        </div>
                    </div>
                    <div class="card-body conversion-controls" style="display: none;">
                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'from_currency')->dropDownList([
                                    'USD' => 'USD',
                                    'UGX' => 'UGX'
                                ], [
                                    'id' => 'conversion-from',
                                    'value' => 'USD'
                                ]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'rate')->textInput([
                                    'type' => 'number',
                                    'id' => 'conversion-rate',
                                    'value' => '3700',
                                    'step' => '0.01',
                                    'min' => '0'
                                ]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'to_currency')->dropDownList([
                                    'UGX' => 'UGX',
                                    'USD' => 'USD'
                                ], [
                                    'id' => 'conversion-to',
                                    'value' => 'UGX'
                                ]) ?>
                            </div>
                        </div>
                        <?= $form->field($model, 'conversional_rate')->hiddenInput(['id' => 'conversion-rate-display'])->label(false) ?>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Payment Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'payment_number')->textInput([
                                    'value' => Payment::generateReference('PAY'),
                                    'readonly' => true
                                ]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'amount')->textInput(['type' => 'number',
                                    'step' => '0.01',
//                                    'readonly' => $type == 'ots'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Payment Method & Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'payment_method')->dropDownList(
                                    Payment::optsPaymentMethod(),
                                    ['prompt' => 'Select Payment Method']
                                ) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'payment_type')->dropDownList(
                                    Payment::optsPaymentType(),
                                    ['prompt' => 'Select Payment Type']
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Additional Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'notes')->textarea(['rows' => 3]) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Save Payment', ['class' => 'btn btn-success btn-lg']) ?>
                    <?= Html::a('Return', $type!=='ots' ? 'reserve': 'ots', ['class' => 'btn btn-secondary btn-lg ms-2']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">Payment Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Payment Number:</span>
                            <strong id="summary-payment-number"><?= Payment::generateReference('PAY') ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Amount Payable (USD):</span>
                            <strong id="payable-amount">$<?= number_format($payable, 2) ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Amount Payable (UGX):</span>
                            <strong id="payable-amount-ugx">UGX <?= number_format($payable * 3700) ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Amount (USD):</span>
                            <strong id="summary-amount">$0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Amount (UGX):</span>
                            <strong id="summary-amount-ugx">UGX 0</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Current Exchange Rate:</span>
                            <strong id="current-exchange-rate">1 USD = UGX 3,700</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Payment Date:</span>
                            <strong id="summary-date"><?= date('Y-m-d') ?></strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Status:</span>
                            <strong id="summary-status">Pending</strong>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">Help</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Currency Conversion:</strong> You can customize the exchange rate if needed by enabling custom conversion.</p>
                        <p><strong>Payment Method:</strong> Select how the payment was made.</p>
                        <p><strong>Payment Type:</strong> Indicate whether this is a deposit, installment, or full payment.</p>
                        <p><strong>Payment Status:</strong> Current status of the payment transaction.</p>
                        <p><strong>Default Conversion:</strong> $1 USD = UGX 3,700.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$script = <<<JS
// Default exchange rate
let exchangeRate = 3700; // USD to UGX exchange rate
let primaryCurrency = 'USD'; // Track which currency the user is entering the amount in

// Toggle custom conversion controls
$('#enable-custom-conversion').on('change', function() {
    if ($(this).is(':checked')) {
        $('.conversion-controls').slideDown();
    } else {
        $('.conversion-controls').slideUp();
        $('#conversion-from').val('USD');
        $('#conversion-to').val('UGX');
        $('#conversion-rate').val(3700);
        exchangeRate = 3700;
        primaryCurrency = 'USD';
        updateRateDisplay();
        updateCurrencyDisplays();
    }
});

// Update exchange rate when currency selection changes
$('#conversion-from, #conversion-to').on('change', function() {
    // Update which currency is primary based on "from" currency
    primaryCurrency = $('#conversion-from').val();
    updateRateDisplay();
    updateCurrencyDisplays();
});

// Update exchange rate when rate input changes
$('#conversion-rate').on('change keyup', function() {
    const newRate = parseFloat($(this).val());
    if (newRate > 0) {
        exchangeRate = newRate;
        updateRateDisplay();
        updateCurrencyDisplays();
    }
});

// Function to update the rate display and direction
function updateRateDisplay() {
    const fromCurrency = $('#conversion-from').val();
    const toCurrency = $('#conversion-to').val();
    
    // If from and to are the same, reset the other dropdown
    if (fromCurrency === toCurrency) {
        if (this.id === 'conversion-from') {
            $('#conversion-to').val(fromCurrency === 'USD' ? 'UGX' : 'USD');
        } else {
            $('#conversion-from').val(toCurrency === 'USD' ? 'UGX' : 'USD');
        }
    }
    
    // Updated rate display based on current selection
    const fromCurrencyFinal = $('#conversion-from').val();
    const toCurrencyFinal = $('#conversion-to').val();
    
    let displayText = '';
    if (fromCurrencyFinal === 'USD' && toCurrencyFinal === 'UGX') {
        // Standard case: USD to UGX
        displayText = '1 USD = UGX ' + exchangeRate.toLocaleString();
    } else {
        // Inverse case: UGX to USD
        const inverseRate = (1 / exchangeRate).toFixed(8);
        displayText = '1 UGX = USD ' + inverseRate;
    }
    
    // Update the display and the hidden form field
    $('#current-exchange-rate').text(displayText);
    $('#conversion-rate-display').val(displayText);
}

// Function to convert between currencies based on selected direction
function convertCurrency(amount, fromCurrency, toCurrency) {
    if (fromCurrency === 'USD' && toCurrency === 'UGX') {
        return Math.round(parseFloat(amount) * exchangeRate);
    } else if (fromCurrency === 'UGX' && toCurrency === 'USD') {
        return parseFloat(amount) / exchangeRate;
    } else {
        // Same currency, no conversion needed
        return parseFloat(amount);
    }
}

// Format USD value with $ symbol and 2 decimal places
function formatUSD(amount) {
    return '$' + parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

// Format UGX value with thousands separators
function formatUGX(amount) {
    return 'UGX ' + parseFloat(amount).toLocaleString();
}

// Update all currency displays
function updateCurrencyDisplays() {
    const fromCurrency = $('#conversion-from').val();
    const toCurrency = $('#conversion-to').val();
    
    // Update payable amount in both currencies
    const payableUSD = parseFloat({$payable});
    const payableUGX = convertCurrency(payableUSD, 'USD', 'UGX');
    
    $('#payable-amount').text(formatUSD(payableUSD));
    $('#payable-amount-ugx').text(formatUGX(payableUGX));

    // Get the current amount from the form
    const amountInput = $('#payment-amount').val() || 0;
    
    // Display the amount based on the conversion direction
    if (fromCurrency === 'USD' && toCurrency === 'UGX') {
        // USD is primary - amount is in USD
        const amountUGX = convertCurrency(amountInput, 'USD', 'UGX');
        $('#summary-amount').text(formatUSD(amountInput));
        $('#summary-amount-ugx').text(formatUGX(amountUGX));
    } else {
        // UGX is primary - amount is in UGX
        const amountUSD = convertCurrency(amountInput, 'UGX', 'USD');
        $('#summary-amount').text(formatUSD(amountUSD));
        $('#summary-amount-ugx').text(formatUGX(amountInput));
    }
}

// Initialize display
updateRateDisplay();
updateCurrencyDisplays();

// Update summary card when form values change
$('#payment-amount').on('change keyup', function() {
    updateCurrencyDisplays();
});

$('#payment-payment_date').on('change', function() {
    $('#summary-date').text($(this).val());
});

$('#payment-payment_status').on('change', function() {
    $('#summary-status').text($(this).find('option:selected').text());
});

// Set form values before submission
$('#payment-form').on('beforeSubmit', function() {
    // Get the current amount from the form
    const amountInput = parseFloat($('#payment-amount').val() || 0);
    const fromCurrency = $('#conversion-from').val();
    const toCurrency = $('#conversion-to').val();
    
    // Store the correct USD amount in the form before submission
    if (fromCurrency === 'UGX' && toCurrency === 'USD') {
        // If UGX is primary, convert to USD for storage
        const amountUSD = convertCurrency(amountInput, 'UGX', 'USD');
        $('#payment-amount').val(amountUSD.toFixed(2));
    }
    
    // Ensure values are set correctly if custom conversion is enabled
    if ($('#enable-custom-conversion').is(':checked')) {
        $('#conversion-rate-display').val($('#current-exchange-rate').text());
    } else {
        // Default values if custom conversion is not enabled
        $('#payment-from_currency').val('USD');
        $('#payment-to_currency').val('UGX');
        $('#payment-rate').val(3700);
        $('#conversion-rate-display').val('1 USD = UGX 3,700');
    }
    return true;
});

// Initialize
$(document).ready(function() {
    // Set initial values for form fields
    $('#payment-from_currency').val('USD');
    $('#payment-to_currency').val('UGX');
    $('#payment-rate').val(3700);
    $('#conversion-rate-display').val('1 USD = UGX 3,700');
});
JS;
$this->registerJs($script);
?>
