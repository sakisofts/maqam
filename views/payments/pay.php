<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\PaymentForm */
use yii\web\View;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
$requestPaymentUrl = Url::to(['api/request-payment']);
$statusUrl = Url::to(['transactions/index']);
$this->title = 'Make Payment';
?>
    <div class="container-fluid bg-white px-3">
        <div class="row">
            <div class="col-12">
                <h1 class="py-3"><?= Html::encode($this->title) ?></h1>

                <?php $form = ActiveForm::begin([
                    'id' => 'payment-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'options' => ['onsubmit' => 'return false;'], // Prevent default form submission
                ]); ?>
                <?= $form->field($model, 'reference')->textInput(['placeholder' => 'Order/Invoice number']) ?>
                <br>
                <?= $form->field($model, 'phone')->textInput(['placeholder' => 'e.g. 0712345678'])->label('Phone Number (with country code)') ?>
                <br>
                <?= $form->field($model, 'amount')->textInput(['type' => 'number', 'step' => '0.01','placeholder' => 'Amount in UGX shs']) ?>
                <br>
                <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
                <br>
                <div class="form-group">
                    <?= Html::submitButton('Pay Now', ['class' => 'btn btn-primary', 'name' => 'payment-button', 'id' => 'payment-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <!-- Add a status message container -->
                <div id="status-message" class="mt-3"></div>
            </div>
        </div>
    </div>

<?php

// Register your script to handle JSON submission with jQuery $.post
$script = <<<JS
$(document).ready(function() {
    $('#payment-button').on('click', function(e) {
        e.preventDefault();
        
        // Get the status message container
        var statusMessageContainer = $('#status-message');
        statusMessageContainer.html('<div class="alert alert-info">Processing payment request...</div>');
        
        // Collect form data
        var formData = {
            reference: $('#paymentform-reference').val(),
            msisdn: $('#paymentform-phone').val(),
            amount: $('#paymentform-amount').val(),
            description: $('#paymentform-description').val()
        };
        
        // Configure jQuery to handle CORS
        $.ajaxSetup({
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true
        });
        
        // Use $.post with JSON data
        $.ajax({
            url: '{$requestPaymentUrl}',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    statusMessageContainer.html('<div class="alert alert-success">Payment initiated successfully!</div>');
                    window.location.href = '{$statusUrl}?id=' + response.data.transaction.id;
                } else {
                    statusMessageContainer.html('<div class="alert alert-danger">Error: ' + response.data.status.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Payment request failed:', status, error);
                statusMessageContainer.html('<div class="alert alert-danger">An error occurred while processing your request. Please try again later.</div>');
            }
        });
        
        return false;
    });
});
JS;

$this->registerJs($script, View::POS_READY);
?>
