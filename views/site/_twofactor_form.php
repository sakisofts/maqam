<?php
/* @var $model app\models\TwoFactorForm */
/* @var $user app\models\User */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="two-factor-form container-fluid bg-white py-4">
    <?php if (!$user->two_factor_enabled): ?>
        <div class="alert alert-info">
            <h4><i class="icon fa fa-info"></i> Two-Factor Authentication</h4>
            <p>Two-factor authentication adds an extra layer of security to your account by requiring more than just a password to sign in.</p>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'enable-2fa-form',
            'enableAjaxValidation' => true,
        ]); ?>

        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Scan QR Code</h3>
                    </div>
                    <div class="box-body text-center">
                        <?php if (isset($model->qrCodeUrl)): ?>
                            <img src="<?= $model->qrCodeUrl ?>" class="img-responsive center-block" alt="QR Code">
                        <?php else: ?>
                            <div class="alert alert-warning">
                                QR code will be generated when you start setup.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Setup Instructions</h3>
                    </div>
                    <div class="box-body">
                        <ol>
                            <li>Download and install an authenticator app on your phone:<br>
                                <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">Google Authenticator (Android)</a><br>
                                <a href="https://apps.apple.com/app/google-authenticator/id388497605" target="_blank">Google Authenticator (iOS)</a>
                            </li>
                            <li>Scan the QR code shown on the left with your authenticator app</li>
                            <li>Enter the 6-digit code from your authenticator app below</li>
                        </ol>

                        <?php if (isset($model->secretKey)): ?>
                            <div class="form-group">
                                <label class="control-label">Secret Key (if you can't scan the QR code)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?= $model->secretKey ?>" readonly>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-copy" data-clipboard-text="<?= $model->secretKey ?>">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?= $form->field($model, 'verificationCode')->textInput([
                            'maxlength' => 6,
                            'placeholder' => 'Enter 6-digit code',
                            'autocomplete' => 'off',
                            'class' => 'form-control input-lg text-center',
                        ])->hint('Enter the 6-digit code from your authenticator app') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Backup Codes</h3>
                    </div>
                    <div class="box-body">
                        <p>Save these backup codes somewhere safe but accessible. If you lose your device, you can use these one-time codes to sign in.</p>

                        <?php if (isset($model->backupCodes) && !empty($model->backupCodes)): ?>
                            <div class="row">
                                <?php foreach ($model->backupCodes as $i => $code): ?>
                                    <div class="col-xs-6 col-md-4">
                                        <code class="backup-code"><?= $code ?></code>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="text-center">
                                <?= Html::button('<i class="fa fa-download"></i> Download Backup Codes', [
                                    'class' => 'btn btn-default',
                                    'id' => 'download-backup-codes',
                                ]) ?>
                                <?= Html::button('<i class="fa fa-copy"></i> Copy All Codes', [
                                    'class' => 'btn btn-default btn-copy',
                                    'data-clipboard-text' => implode("\n", $model->backupCodes),
                                ]) ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                Backup codes will be generated when you complete the setup.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-left">
            <?php if (!isset($model->qrCodeUrl)): ?>
                <?= Html::submitButton('<i class="fa fa-play text-white"></i> Start Setup', ['class' => 'btn btn-primary btn-lg', 'name' => 'start-setup']) ?>
            <?php else: ?>
                <?= Html::submitButton('<i class="fa fa-shield text-white"></i> Enable Two-Factor Authentication', ['class' => 'btn btn-success btn-lg']) ?>
            <?php endif; ?>
        </div>

        <?php ActiveForm::end(); ?>

    <?php else: ?>
        <!-- Already enabled 2FA -->
        <div class="alert alert-success">
            <h4><i class="icon fa fa-check"></i> Two-Factor Authentication is Enabled</h4>
            <p>Your account is currently protected with two-factor authentication.</p>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Two-Factor Authentication Status</h3>
                    </div>
                    <div class="box-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <b>Status</b> <span class="pull-right label label-success">Enabled</span>
                            </li>
                            <li class="list-group-item">
                                <b>Enabled On</b> <span class="pull-right"><?= Yii::$app->formatter->asDatetime($user->two_factor_enabled_at) ?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Recovery Codes</b> <span class="pull-right"><?= $user->remaining_recovery_codes ?> remaining</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= Html::a('<i class="fa fa-refresh"></i> Generate New Recovery Codes', ['user/generate-recovery-codes'], [
                    'class' => 'btn btn-block btn-info',
                    'data' => [
                        'confirm' => 'Are you sure you want to generate new recovery codes? This will invalidate all existing recovery codes.',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= Html::a('<i class="fa fa-times"></i> Disable Two-Factor Authentication', ['user/disable-2fa'], [
                    'class' => 'btn btn-block btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to disable two-factor authentication? This will make your account less secure.',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    $(document).ready(function() {
        // Copy button functionality
        var clipboard = new ClipboardJS('.btn-copy');

        clipboard.on('success', function(e) {
            $(e.trigger).tooltip({title: "Copied!", trigger: "manual"});
            $(e.trigger).tooltip('show');
            setTimeout(function() {
                $(e.trigger).tooltip('hide');
            }, 1000);
            e.clearSelection();
        });

        // Download backup codes
        $('#download-backup-codes').on('click', function() {
            var backupCodes = <?= isset($model->backupCodes) ? json_encode(implode("\n", $model->backupCodes)) : '""' ?>;
            var element = document.createElement('a');
            element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(backupCodes));
            element.setAttribute('download', 'recovery-codes.txt');
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        });
    });
</script>
