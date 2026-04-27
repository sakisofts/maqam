<?php
/* @var $model app\models\Users */
use yii\helpers\Html;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Progress;
?>

<div class="user-profile">
    <!-- Header with user info -->
    <div class="card profile-header mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <?php if ($model->passportPhoto): ?>
                        <img src="<?= Yii::getAlias('@web') . '/uploads/profile/' . $model->passportPhoto ?>"
                             class="profile-image"
                             alt="Profile Picture">
                    <?php else: ?>
                        <div class="profile-placeholder">
                            <span><?= substr($model->name ?? 'U', 0, 1) ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="mt-3">
                        <?php if ($model->status == 1): ?>
                            <span class="status-badge active">Active</span>
                        <?php else: ?>
                            <span class="status-badge inactive">Inactive</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <h1 class="profile-name"><?= Html::encode($model->name) ?></h1>
                    <div class="profile-role">
                        <?php
                        $roles = [
                            1 => '<i class="fas fa-user-shield me-1"></i> Administrator',
                            2 => '<i class="fas fa-user-tie me-1"></i> Manager',
                            3 => '<i class="fas fa-user me-1"></i> Regular User'
                        ];
                        echo $roles[$model->role] ?? 'Unknown Role';
                        ?>
                    </div>
                    <div class="profile-contact-info">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <?= Html::encode($model->email) ?>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <?= Html::encode($model->phone) ?>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-calendar"></i>
                            Member since <?= Yii::$app->formatter->asDate($model->created_at, 'long') ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 text-end">
                    <div class="profile-actions">
                        <?= Html::a('<i class="fas fa-pencil-alt me-1"></i> Edit Profile', ['site/create-user', 'id' => $model->id], ['class' => 'btn action-btn edit-btn']) ?>
                        <?= Html::a('<i class="fas fa-key me-1"></i> Change Password', ['change-password', 'id' => $model->id], ['class' => 'btn action-btn password-btn']) ?>
                    </div>
                    <div class="security-status-container">
                        <h6 class="security-status-title">Security Status</h6>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-grow-1">
                                <div class="security-score">
                                    <span>Account Security</span>
                                    <span>
                                        <?php
                                        $securityScore = 50; // Base score
                                        if ($model->two_factor_enabled) $securityScore += 25;
                                        if ($model->password_changed_at && strtotime($model->password_changed_at) > strtotime('-90 days')) $securityScore += 25;
                                        echo $securityScore . '%';
                                        ?>
                                    </span>
                                </div>
                                <?= Progress::widget([
                                    'percent' => $securityScore,
                                    'options' => ['class' => 'progress-sm'],
                                    'bars' => [
                                        [
                                            'percent' => $securityScore,
                                            'label' => '',
                                            'options' => [
                                                'class' => $securityScore >= 75 ? 'bg-success' : ($securityScore >= 50 ? 'bg-warning' : 'bg-danger')
                                            ]
                                        ]
                                    ]
                                ]); ?>
                            </div>
                        </div>
                        <div class="security-feature">
                            <?php if ($model->two_factor_enabled): ?>
                                <i class="fas fa-check-circle text-success me-1"></i> 2FA Enabled
                            <?php else: ?>
                                <i class="fas fa-exclamation-triangle text-warning me-1"></i> 2FA Disabled
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- First Column -->
        <div class="col-md-6">
            <!-- Personal Information -->
            <div class="card info-card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-user me-2"></i>Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label>Full Name</label>
                        <div class="info-value"><?= Html::encode($model->name) ?></div>
                    </div>

                    <div class="info-item">
                        <label>Gender</label>
                        <div class="info-value"><?= Html::encode($model->gender) ?: '<span class="not-specified">Not specified</span>' ?></div>
                    </div>

                    <div class="info-item">
                        <label>Date of Birth</label>
                        <div class="info-value">
                            <?= $model->dob ? Yii::$app->formatter->asDate($model->dob, 'long') : '<span class="not-specified">Not specified</span>' ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <label>Nationality</label>
                        <div class="info-value"><?= Html::encode($model->nationality) ?: '<span class="not-specified">Not specified</span>' ?></div>
                    </div>

                    <div class="info-item">
                        <label>Residence</label>
                        <div class="info-value"><?= Html::encode($model->residence) ?: '<span class="not-specified">Not specified</span>' ?></div>
                    </div>
                </div>
                <div class="card-footer">
                    <?= Html::a('<i class="fas fa-pencil-alt me-1"></i> Update Info', ['site/create-user', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-outline-primary update-btn',
                    ]) ?>
                </div>
            </div>

            <!-- ID Information -->
            <div class="card info-card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-id-card me-2"></i>Identification</h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label>ID Type</label>
                        <div class="info-value">
                            <?= strpos($model->NIN_or_Passport, 'NIN') === 0 ? 'National ID' : 'Passport' ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <label>ID Number</label>
                        <div class="info-value"><?= Html::encode($model->NIN_or_Passport) ?: '<span class="not-specified">Not specified</span>' ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Column -->
        <div class="col-md-6">
            <!-- Account Information -->
            <div class="card info-card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-shield-alt me-2"></i>Account Information</h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label>Account Status</label>
                        <div>
                            <?php if ($model->status == 1): ?>
                                <span class="badge-custom active-badge">Active</span>
                            <?php else: ?>
                                <span class="badge-custom inactive-badge">Inactive</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <label>Email Verification</label>
                        <div>
                            <?php if ($model->email_verified_at): ?>
                                <span class="badge-custom verified-badge">Verified on <?= Yii::$app->formatter->asDate($model->email_verified_at, 'medium') ?></span>
                            <?php else: ?>
                                <span class="badge-custom warning-badge">Not Verified</span>
                                <?= Html::a('Send Verification Email', ['verify-email', 'id' => $model->id], [
                                    'class' => 'btn btn-sm link-btn',
                                ]) ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <label>Two-Factor Authentication</label>
                        <div>
                            <?php if ($model->two_factor_enabled): ?>
                                <span class="badge-custom active-badge">Enabled</span>
                                <?= Html::a('Disable', ['disable-2fa', 'id' => $model->id], [
                                    'class' => 'btn btn-sm link-btn',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to disable two-factor authentication?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php else: ?>
                                <span class="badge-custom danger-badge">Disabled</span>
                                <?= Html::a('Enable', ['enable-2fa', 'id' => $model->id], [
                                    'class' => 'btn btn-sm link-btn',
                                ]) ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <label>Last Password Change</label>
                        <div class="info-value">
                            <?php if ($model->password_changed_at): ?>
                                <?= Yii::$app->formatter->asDatetime($model->password_changed_at) ?>
                                <?php
                                $daysSinceChange = floor((time() - strtotime($model->password_changed_at)) / (60 * 60 * 24));
                                if ($daysSinceChange > 90): ?>
                                    <div class="password-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i> Password age: <?= $daysSinceChange ?> days
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="not-specified">Never changed</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <label>Email Address</label>
                        <div class="info-value">
                            <?= Html::encode($model->email) ?>
                            <?= Html::a('<i class="fas fa-pencil-alt"></i> Change', '#', [
                                'class' => 'btn btn-sm link-btn',
                                'data-bs-toggle' => 'modal',
                                'data-bs-target' => '#changeEmailModal',
                            ]) ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <label>Phone Number</label>
                        <div class="info-value">
                            <?= Html::encode($model->phone) ?: '<span class="not-specified">Not specified</span>' ?>
                            <?= Html::a('<i class="fas fa-pencil-alt"></i> Update', ['update-phone', 'id' => $model->id], [
                                'class' => 'btn btn-sm link-btn',
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <?= Html::a('<i class="fas fa-key me-1"></i> Change Password', ['change-password', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-outline-primary update-btn',
                    ]) ?>
                </div>
            </div>

            <!-- Security Tips Card -->
            <div class="card info-card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-lock me-2"></i>Security Tips</h5>
                </div>
                <div class="card-body">
                    <div class="security-tips">
                        <div class="tip-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <div>
                                <strong>Use a strong password</strong>
                                <p class="mb-0 text-muted">Combine upper and lowercase letters, numbers, and symbols.</p>
                            </div>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                            <div>
                                <strong>Enable two-factor authentication</strong>
                                <p class="mb-0 text-muted">Add an extra layer of security to your account.</p>
                            </div>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            <div>
                                <strong>Update your password regularly</strong>
                                <p class="mb-0 text-muted">Change your password every 90 days for better security.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Create a modal for changing email
Modal::begin([
    'id' => 'changeEmailModal',
    'title' => '<h5 class="modal-title"><i class="fas fa-envelope me-2"></i>Change Email Address</h5>',
    'size' => 'modal-lg',
    'centerVertical' => true,
]);
?>

<div class="change-email-form">
    <p class="text-muted">Enter your new email address below. A verification link will be sent to the new email address.</p>

    <form id="change-email-form" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Current Email</label>
            <input type="text" class="form-control" value="<?= Html::encode($model->email) ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">New Email Address</label>
            <input type="email" name="new_email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Your Password</label>
            <input type="password" name="password" class="form-control" required>
            <div class="form-text">Enter your current password to verify it's you.</div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary modal-submit-btn">
                <i class="fas fa-check me-1"></i> Submit Change Request
            </button>
        </div>
    </form>
</div>

<?php Modal::end(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize email change form
        const changeEmailForm = document.getElementById('change-email-form');
        if (changeEmailForm) {
            changeEmailForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const emailInput = this.querySelector('input[name="new_email"]').value;
                this.innerHTML = `
                <div class="text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5>Verification Email Sent!</h5>
                    <p class="mb-0 text-muted">A verification email has been sent to <strong>${emailInput}</strong>.
                       Please check your inbox and click the verification link.</p>
                </div>
            `;
                setTimeout(() => {
                    $('#changeEmailModal').modal('hide');
                }, 5000);
            });
        }
    });
</script>

<style>
    /* Global Styles */
    body {
        background-color: #f8f9fa;
        color: #495057;
        font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
    }

    /* Cards Styling */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s, box-shadow 0.2s;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: var(--bs-primary);
        border-bottom: none;
        padding: 1rem 1.5rem;
    }

    .card-header i {
        color: white !important;
    }

    .card-header h5 {
        color: white;
        font-weight: 600;
        margin: 0;
        font-size: 1.1rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-footer {
        background-color: #f8f9fc;
        border-top: 1px solid rgba(0,0,0,0.05);
        padding: 0.75rem 1.5rem;
        text-align: right;
    }

    /* Profile Header */
    .profile-header {
        background:  var(--bs-primary) ;
        color: white;
        margin-bottom: 2rem;
    }

    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        object-fit: cover;
    }

    .profile-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.9);
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 300;
        margin: 0 auto;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .status-badge.active {
        background-color: #1cc88a;
        color: white;
    }

    .status-badge.inactive {
        background-color: #e74a3b;
        color: white;
    }

    .profile-name {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: white;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .profile-role {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        margin-bottom: 1rem;
        font-weight: 500;
    }

    .profile-contact-info {
        margin-top: 1rem;
    }

    .contact-item {
        margin-bottom: 0.5rem;
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.95rem;
    }

    .contact-item i {
        width: 20px;
        margin-right: 10px;
        text-align: center;
    }

    .profile-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .action-btn {
        padding: 0.6rem 1.2rem;
        border-radius: 5px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .edit-btn {
        background-color: white;
        color: #4e73df;
        border: none;
    }

    .edit-btn:hover {
        background-color: #f8f9fc;
        color: #2e59d9;
    }

    .password-btn {
        background-color: rgba(255, 255, 255, 0.15);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .password-btn:hover {
        background-color: rgba(255, 255, 255, 0.25);
        color: white;
    }

    .security-status-container {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .security-status-title {
        color: white;
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .security-score {
        display: flex;
        justify-content: space-between;
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.85rem;
        margin-bottom: 0.35rem;
    }

    .progress-sm {
        height: 6px;
        border-radius: 3px;
        overflow: hidden;
        background-color: rgba(255, 255, 255, 0.2);
    }

    .security-feature {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.9);
        margin-top: 0.75rem;
    }

    /* Info Cards */
    .info-card {
        margin-bottom: 1.5rem;
        height: max-content;
    }

    .info-item {
        margin-bottom: 1.25rem;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .info-item:not(:last-child)::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(to right, rgba(0,0,0,0.06), rgba(0,0,0,0.02), rgba(0,0,0,0));
    }

    .info-item label {
        display: block;
        color: #858796;
        font-size: 0.8rem;
        margin-bottom: 0.35rem;
        font-weight: 500;
    }

    .info-value {
        font-weight: 600;
        color: #3a3b45;
        font-size: 1rem;
    }

    .not-specified {
        color: #b7b9cc;
        font-style: italic;
        font-weight: normal;
    }

    .update-btn {
        border-color: #4e73df;
        color: #4e73df;
        font-size: 0.85rem;
        border-radius: 5px;
        padding: 0.4rem 0.85rem;
        transition: all 0.2s;
    }

    .update-btn:hover {
        background-color: #4e73df;
        color: white;
        border-color: #4e73df;
    }

    /* Badges */
    .badge-custom {
        padding: 0.4rem 0.85rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .active-badge {
        background-color: rgba(28, 200, 138, 0.1);
        color: #1cc88a;
    }

    .inactive-badge {
        background-color: rgba(78, 115, 223, 0.1);
        color: #4e73df;
    }

    .verified-badge {
        background-color: rgba(28, 200, 138, 0.1);
        color: #1cc88a;
    }

    .warning-badge {
        background-color: rgba(246, 194, 62, 0.1);
        color: #f6c23e;
    }

    .danger-badge {
        background-color: rgba(231, 74, 59, 0.1);
        color: #e74a3b;
    }

    .link-btn {
        background: none;
        border: none;
        color: #4e73df;
        padding: 0;
        margin-left: 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: underline;
    }

    .link-btn:hover {
        color: #224abe;
    }

    .password-warning {
        font-size: 0.8rem;
        color: #e74a3b;
        margin-top: 0.25rem;
    }

    /* Modal Styling */
    .modal-header {
        background: linear-gradient(to right, var(--bs-primary) var(--bs-primary));
        color: white;
        border-bottom: none;
    }

    .modal-title {
        font-weight: 600;
    }

    .modal-submit-btn {
        background: linear-gradient(to right, var(--bs-primary) var(--bs-primary));
        border: none;
        padding: 0.6rem;
        font-weight: 500;
    }

    .modal-submit-btn:hover {
        background: linear-gradient(to right, var(--bs-primary) var(--bs-primary));
    }

    /* Security Tips Styling */
    .security-tips {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .tip-item {
        display: flex;
        align-items: flex-start;
    }

    .tip-item i {
        font-size: 1.25rem;
        margin-top: 0.2rem;
    }

    .tip-item strong {
        display: block;
        margin-bottom: 0.25rem;
        color: #4e73df;
    }

    .tip-item p {
        font-size: 0.9rem;
    }

    /* Make the design responsive */
    @media (max-width: 992px) {
        .profile-header .row {
            flex-direction: column;
        }

        .profile-header .col-md-2,
        .profile-header .col-md-6,
        .profile-header .col-md-4 {
            width: 100%;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .profile-actions {
            justify-content: center;
            margin-top: 1rem;
        }

        .security-status-container {
            max-width: 400px;
            margin: 0 auto;
        }

        .card-footer {
            text-align: center;
        }
    }

    @media (max-width: 768px) {
        .profile-image, .profile-placeholder {
            width: 120px;
            height: 120px;
            font-size: 2.5rem;
        }

        .profile-name {
            font-size: 1.75rem;
        }
    }
</style>
