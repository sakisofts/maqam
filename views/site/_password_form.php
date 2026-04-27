<?php
/* @var $model app\models\PasswordChangeForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="password-change-form container-fluid bg-white py-4">
    <?php $form = ActiveForm::begin([
        'id' => 'password-form',
        'enableAjaxValidation' => true,
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'currentPassword')->passwordInput([
                'maxlength' => true,
                'autocomplete' => 'current-password',
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'newPassword')->passwordInput([
                'maxlength' => true,
                'autocomplete' => 'new-password',
            ])->hint('Password must be at least 8 characters and include uppercase, lowercase, number, and special character.') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'confirmPassword')->passwordInput([
                'maxlength' => true,
                'autocomplete' => 'new-password',
            ]) ?>
        </div>
    </div>

    <div class="password-strength-meter">
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <p class="password-strength-text text-muted">Password strength: <span>Too weak</span></p>
    </div>

    <div class="form-group text-left">
        <?= Html::submitButton('<i class="fa fa-key text-dark"></i> Change Password', ['class' => 'btn btn-warning btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
    $(document).ready(function() {
        // Simple password strength meter
        $('#passwordchangeform-newpassword').on('keyup', function() {
            var password = $(this).val();
            var strength = 0;

            if (password.length >= 8) strength += 20;
            if (password.match(/[A-Z]/)) strength += 20;
            if (password.match(/[a-z]/)) strength += 20;
            if (password.match(/[0-9]/)) strength += 20;
            if (password.match(/[^A-Za-z0-9]/)) strength += 20;

            $('.password-strength-meter .progress-bar').css('width', strength + '%');
            $('.password-strength-meter .progress-bar').attr('aria-valuenow', strength);

            var strengthText = 'Too weak';
            if (strength >= 20) strengthText = 'Weak';
            if (strength >= 40) strengthText = 'Fair';
            if (strength >= 60) strengthText = 'Good';
            if (strength >= 80) strengthText = 'Strong';

            $('.password-strength-text span').text(strengthText);

            // Change color based on strength
            $('.password-strength-meter .progress-bar').removeClass('progress-bar-danger progress-bar-warning progress-bar-info progress-bar-success');

            if (strength < 40) {
                $('.password-strength-meter .progress-bar').addClass('progress-bar-danger');
            } else if (strength < 60) {
                $('.password-strength-meter .progress-bar').addClass('progress-bar-warning');
            } else if (strength < 80) {
                $('.password-strength-meter .progress-bar').addClass('progress-bar-info');
            } else {
                $('.password-strength-meter .progress-bar').addClass('progress-bar-success');
            }
        });
    });
</script>
