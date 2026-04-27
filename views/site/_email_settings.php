<?php
/* @var $model app\models\User */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="email-settings-form container-fluid bg-white py-4">
    <?php $form = ActiveForm::begin([
        'id' => 'email-settings-form',
        'enableAjaxValidation' => true,
    ]); ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'email')->textInput([
                'maxlength' => true,
                'type' => 'email',
                'disabled' => !$model->isNewRecord && $model->email_change_token !== null,
            ])->hint(
                $model->email_change_token !== null ?
                    'Email change pending verification. Please check your inbox.' :
                    'Changing your email will require verification.'
            ) ?>
        </div>
    </div>

    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Email Notifications</h3>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'notify_login')->checkbox(['label' => 'Email me when someone logs in to my account from a new device or location']) ?>

            <?= $form->field($model, 'notify_updates')->checkbox(['label' => 'Email me about important account updates or security notifications']) ?>

            <?= $form->field($model, 'notify_news')->checkbox(['label' => 'Email me about new features, updates and news']) ?>
        </div>
    </div>

    <?php if ($model->email_change_token !== null): ?>
        <div class="alert alert-info">
            <h4><i class="icon fa fa-info"></i> Email Change Pending</h4>
            <p>You have a pending email change to: <strong><?= Html::encode($model->new_email) ?></strong></p>
            <p>Please check your new email inbox to confirm this change.</p>

            <?= Html::a('<i class="fa fa-times"></i> Cancel Email Change', ['user/cancel-email-change'], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => 'Are you sure you want to cancel this email change?',
                    'method' => 'post',
                ],
            ]) ?>

            <?= Html::a('<i class="fa fa-refresh"></i> Resend Verification Email', ['user/resend-email-verification'], [
                'class' => 'btn btn-info',
                'data' => [
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    <?php endif; ?>

    <div class="form-group text-left">
        <?= Html::submitButton('<i class="fa fa-save text-white"></i> Save Email Settings', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
