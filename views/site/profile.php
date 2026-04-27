<?php
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $passwordForm app\models\PasswordChangeForm */
/* @var $profile app\models\UserProfile */
/* @var $twoFactorForm app\models\TwoFactorForm */

use yii\bootstrap5\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'My Profile';
?>

<div class="user-profile container-fluid py-4">
    <div class="row g-4">
        <div class="col-md-3">
            <!-- Profile Card -->
            <div class="card shadow-sm rounded-3 mb-4 overflow-hidden border-0">
                <div class="card-body p-0">
                    <div class="bg-primary bg-gradient text-center p-4">
                        <?php if (!empty($profile->avatar)): ?>
                            <?= Html::img($profile->getAvatarUrl(), ['class' => 'rounded-circle avatar-xl shadow border border-3 border-white', 'alt' => 'User Avatar', 'style' => 'width: 120px; height: 120px; object-fit: cover;']) ?>
                        <?php else: ?>
                            <div class="rounded-circle avatar-xl shadow border border-3 border-white d-flex align-items-center justify-content-center mx-auto" style="background-color: #3c8dbc; color: white; font-size: 48px; width: 120px; height: 120px;">
                                <?= strtoupper(substr($model->name, 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                        <h4 class="text-white fw-bold mt-3 mb-1"><?= Html::encode($model->name) ?></h4>
                        <p class="text-white-50 mb-0"><?= Html::encode($profile->name ?? '') ?></p>
                    </div>

                    <div class="p-4">
                        <ul class="list-group list-group-flush rounded-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-envelope text-primary me-3"></i>
                                    <span>Email</span>
                                </div>
                                <span class="text-muted"><?= Html::encode($model->email) ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3 border-top">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-calendar text-primary me-3"></i>
                                    <span>Member Since</span>
                                </div>
                                <span class="text-muted"><?= Yii::$app->formatter->asDate($model->created_at) ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3 border-top">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-clock-o text-primary me-3"></i>
                                    <span>Last Login</span>
                                </div>
                                <span class="text-muted"><?= Yii::$app->formatter->asDatetime($model->last_login_at ?? date('Y-m-d')) ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3 border-top">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-user-circle text-primary me-3"></i>
                                    <span>Account Status</span>
                                </div>
                                <?php if ($model->status == 10): ?>
                                    <span class="badge bg-success rounded-pill px-3 py-2">Active</span>
                                <?php elseif ($model->status == 0): ?>
                                    <span class="badge bg-danger rounded-pill px-3 py-2">Inactive</span>
                                <?php else: ?>
                                    <span class="badge bg-warning rounded-pill px-3 py-2">Pending</span>
                                <?php endif; ?>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3 border-top">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-shield text-primary me-3"></i>
                                    <span>2FA</span>
                                </div>
                                <?php if ($model->two_factor_enabled): ?>
                                    <span class="badge bg-success rounded-pill px-3 py-2">Enabled</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">Disabled</span>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Security Info Box -->
            <div class="card shadow-sm rounded-3 border-0 mb-4">
                <div class="card-header bg-gradient bg-danger text-white py-3">
                    <h5 class="card-title m-0 d-flex align-items-center">
                        <i class="fa fa-lock me-2 text-white"></i> Security Information
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="security-item mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon-box bg-light rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fa fa-key text-danger"></i>
                            </div>
                            <h6 class="fw-bold mb-0">Password</h6>
                        </div>
                        <p class="text-muted ms-0 ms-md-5 ps-2 mb-0 small">
                            Last changed: <?= $model->password_changed_at ? Yii::$app->formatter->asDate($model->password_changed_at) : date('Y-m-d') ?>
                        </p>
                    </div>

                    <div class="security-item mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon-box bg-light rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fa fa-shield text-danger"></i>
                            </div>
                            <h6 class="fw-bold mb-0">Two-Factor Authentication</h6>
                        </div>
                        <p class="text-muted ms-0 ms-md-5 ps-2 mb-0 small">
                            <?= $model->two_factor_enabled ? 'Enabled' : 'Not enabled' ?>
                        </p>
                    </div>

                    <div class="security-item">
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon-box bg-light rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fa fa-sign-in text-danger"></i>
                            </div>
                            <h6 class="fw-bold mb-0">Recent Logins</h6>
                        </div>
                        <p class="text-muted ms-0 ms-md-5 ps-2 mb-0 small">
                            <a href="<?= Url::to(['user/login-history']) ?>" class="text-decoration-none">View login history</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fa fa-check-circle fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading">Success!</h5>
                            <p class="mb-0"><?= Yii::$app->session->getFlash('success') ?></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fa fa-exclamation-circle fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading">Error!</h5>
                            <p class="mb-0"><?= Yii::$app->session->getFlash('error') ?></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Profile Tabs -->
            <div class="card shadow-sm rounded-3 border-0">
                <div class="card-body p-0">
                    <?= Tabs::widget([
                        'options' => ['class' => 'nav-fill text-primary'],
                        'itemOptions' => ['class' => 'fw-medium text-primary'],
                        'headerOptions' => ['class' => 'p-3 text-primary'],
                        'items' => [
                            [
                                'label' => '<i class="fa fa-user text-primary me-2"></i> Profile Details',
                                'content' => $this->render('_profile_form', ['profile' => $profile]),
                                'active' => true,
                                'options' => ['class' => 'p-4'],
                            ],
                            [
                                'label' => '<i class="fa fa-key text-primary me-2"></i> Change Password',
                                'content' => $this->render('_password_form', ['model' => $passwordForm]),
                                'options' => ['class' => 'p-4'],
                            ],
                            [
                                'label' => '<i class="fa fa-shield text-primary me-2"></i> Two-Factor Authentication',
                                'content' => $this->render('_twofactor_form', ['model' => $twoFactorForm, 'user' => $model]),
                                'options' => ['class' => 'p-4'],
                            ],
                            [
                                'label' => '<i class="fa fa-envelope text-primary me-2"></i> Email Settings',
                                'content' => $this->render('_email_settings', ['model' => $model]),
                                'options' => ['class' => 'p-4'],
                            ],
                            [
                                'label' => '<i class="fa fa-bell text-primary me-2"></i> Notifications',
                                'content' => $this->render('_notification_settings', ['model' => $model]),
                                'options' => ['class' => 'p-4'],
                            ],
                        ],
                        'encodeLabels' => false,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
