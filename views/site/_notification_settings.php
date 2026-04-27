<?php
/* @var $model app\models\User */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="notification-settings-form container-fluid bg-white py-4">
    <?php $form = ActiveForm::begin([
        'id' => 'notification-settings-form',
        'enableAjaxValidation' => true,
    ]); ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Web Notifications</h3>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'web_notify_login')->checkbox(['label' => 'Notify me when someone logs in to my account from a new device or location']) ?>

            <?= $form->field($model, 'web_notify_updates')->checkbox(['label' => 'Notify me about important account updates or security events']) ?>

            <?= $form->field($model, 'web_notify_messages')->checkbox(['label' => 'Notify me about new messages']) ?>

            <?= $form->field($model, 'web_notify_news')->checkbox(['label' => 'Notify me about new features and updates']) ?>
        </div>
    </div>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Mobile Push Notifications</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($model->mobile_devices)): ?>
                <?= $form->field($model, 'push_notify_login')->checkbox(['label' => 'Send push notifications about new logins to my account']) ?>

                <?= $form->field($model, 'push_notify_updates')->checkbox(['label' => 'Send push notifications about account updates or security events']) ?>

                <?= $form->field($model, 'push_notify_messages')->checkbox(['label' => 'Send push notifications for new messages']) ?>

                <?= $form->field($model, 'push_notify_news')->checkbox(['label' => 'Send push notifications about new features and updates']) ?>

                <div class="form-group">
                    <label>Registered Mobile Devices</label>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Device</th>
                                <th>Last Used</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($model->mobile_devices as $device): ?>
                                <tr>
                                    <td><?= Html::encode($device->device_name) ?></td>
                                    <td><?= Yii::$app->formatter->asDatetime($device->last_used_at) ?></td>
                                    <td>
                                        <?= Html::a('<i class="fa fa-trash"></i> Remove', ['user/remove-device', 'id' => $device->id], [
                                            'class' => 'btn btn-xs btn-danger',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to remove this device? You will no longer receive push notifications on it.',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <p>You don't have any mobile devices registered for push notifications.</p>
                    <p>To enable push notifications, please install our mobile app and log in with your account.</p>

                    <div class="text-center">
                        <a href="#" class="btn btn-default">
                            <i class="fa fa-android"></i> Android App
                        </a>
                        <a href="#" class="btn btn-default">
                            <i class="fa fa-apple"></i> iOS App
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-group text-left">
        <?= Html::submitButton('<i class="fa fa-save text-white"></i> Save Notification Settings', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

