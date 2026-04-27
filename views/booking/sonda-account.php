<?php
/* @var $data app\models\Member */

use yii\helpers\Html;
use yii\widgets\DetailView;
$this->title = "Account Details - ".Yii::$app->name;
?>

    <div class="member-view">
        <div class="container-fluid bg-white py-4">
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <h1 class="display-5 fw-bold text-primary"><?= Html::encode($data->name) ?></h1>
                    <p class="lead">Reference: <span class="badge bg-info"><?= Html::encode($data->reference) ?></span></p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <?= Html::a('Update', ['update', 'id' => $data->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $data->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this member?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>

            <!-- Member Profile Card -->
            <div class="row mb-4">
                <div class="col-md-3 mb-4 mb-md-0">
                    <!-- New styled profile card based on reference image -->
                    <div class="card border-0 shadow-sm member-profile-card">
                        <div class="profile-header bg-gradient-primary text-center p-4">
                            <?php if ($data->image): ?>
                                <div class="profile-circle mx-auto">
                                    <img src="<?= Yii::getAlias('@web/uploads/members/' . $data->image) ?>"
                                         class="w-100 h-100 rounded-circle"
                                         alt="Profile Image"
                                         style="object-fit: cover;">
                                </div>
                            <?php else: ?>
                                <div class="profile-circle mx-auto d-flex align-items-center justify-content-center">
                                    <span class="initial-letter"><?= strtoupper(substr($data->name, 0, 1)) ?></span>
                                </div>
                            <?php endif; ?>
                            <h4 class="text-white text-uppercase fw-bold mt-3 mb-0"><?= Html::encode($data->name) ?></h4>
                        </div>

                        <div class="card-body p-3">
                            <div class="text-center mb-3">
                            <span class="badge bg-success px-3 py-2">
                                <?= Html::encode($data->savingFor) ?> Saving Plan
                            </span>
                            </div>

                            <div class="contact-info mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-telephone-fill me-2 text-primary"></i>
                                    <div><?= Html::encode($data->phone) ?></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-envelope-fill me-2 text-primary"></i>
                                    <div class="text-truncate"><?= Html::encode($data->email) ?></div>
                                </div>
                            </div>

                            <div class="d-grid mt-3">
                                <a href="mailto:<?= Html::encode($data->email) ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-envelope me-2"></i>Send Email
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Saving Status Card -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Saving Status</h5>
                            <div class="mb-3">
                                <label class="form-label small text-muted">Target Amount</label>
                                <h4>UGX <?= number_format($data->targetAmount) ?></h4>
                            </div>
                            <?php if ($data->savingFor == 'Umrah'): ?>
                                <div class="mb-3">
                                    <label class="form-label small text-muted">Umrah Target</label>
                                    <p><?= Html::encode($data->umrahSavingTarget) ?></p>
                                </div>
                            <?php elseif ($data->savingFor == 'Hajj' && $data->hajjSavingTarget): ?>
                                <div class="mb-3">
                                    <label class="form-label small text-muted">Hajj Target</label>
                                    <p><?= Html::encode($data->hajjSavingTarget) ?></p>
                                </div>
                            <?php endif; ?>
                            <div class="mb-2">
                                <label class="form-label small text-muted">Status</label>
                                <span class="badge bg-<?= $data->process_status == 'pending' ? 'warning' : 'success' ?>">
                            <?= ucfirst(Html::encode($data->process_status)) ?>
                        </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Member Details (Unchanged) -->
                <div class="col-md-9">
                    <div class="card border-0 shadow">
                        <div class="card-header bg-white">
                            <ul class="nav nav-tabs card-header-tabs" id="memberTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal"
                                            type="button" role="tab" aria-controls="personal" aria-selected="true">
                                        <i class="bi bi-person me-2"></i>Personal Information
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address"
                                            type="button" role="tab" aria-controls="address" aria-selected="false">
                                        <i class="bi bi-geo-alt me-2"></i>Address
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="identification-tab" data-bs-toggle="tab" data-bs-target="#identification"
                                            type="button" role="tab" aria-controls="identification" aria-selected="false">
                                        <i class="bi bi-card-text me-2"></i>Identification
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="emergency-tab" data-bs-toggle="tab" data-bs-target="#emergency"
                                            type="button" role="tab" aria-controls="emergency" aria-selected="false">
                                        <i class="bi bi-exclamation-triangle me-2"></i>Emergency Contact
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="memberTabContent">
                                <!-- Personal Information Tab -->
                                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Full Name</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->name) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Gender</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->gender) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Date of Birth</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->dob) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Place of Birth</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->placeOfBirth) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Father's Name</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->fatherName) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Mother's Name</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->motherName) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Marital Status</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->maritalStatus) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Nationality</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->nationality) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Occupation</label>
                                                <p class="form-control-plaintext"><?= $data->occupation ? Html::encode($data->occupation) : '<span class="text-muted">Not provided</span>' ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Position</label>
                                                <p class="form-control-plaintext"><?= $data->position ? Html::encode($data->position) : '<span class="text-muted">Not provided</span>' ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address Tab -->
                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Country</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->country) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">District</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->district) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">County</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->county) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Subcounty</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->subcounty) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Parish</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->parish) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Village</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->village) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Residence</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->residence) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Identification Tab -->
                                <div class="tab-pane fade" id="identification" role="tabpanel" aria-labelledby="identification-tab">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Identification Type</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->identificationType) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">NIN/Passport Number</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->nin_or_passport) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Date of Expiry</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->dateOfExpiry) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Emergency Contact Tab -->
                                <div class="tab-pane fade" id="emergency" role="tabpanel" aria-labelledby="emergency-tab">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Next of Kin</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->nextOfKin) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Relationship</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->relationship) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Address</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->nextOfKinAddress) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">Mobile Number</label>
                                                <p class="form-control-plaintext"><?= Html::encode($data->mobileNo) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Information -->
                    <div class="card border-0 shadow mt-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Transaction History</h5>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerCss("
    .form-control-plaintext {
        font-weight: 500;
        padding-bottom: 0.25rem;
        border-bottom: 1px solid #eee;
    }
    
    /* New styles for the profile section based on reference image */
    .member-profile-card {
        overflow: hidden;
        border-radius: 0.5rem;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--bs-primary), var(--bs-primary));
        color: white;
    }
    
    .profile-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 2px solid var(--bs-secondary);
        background-color: var(--bs-primary);
        position: relative;
        overflow: hidden;
    }
    
    .initial-letter {
        font-size: 2.5rem;
        font-weight: bold;
        color: white;
    }
    
     .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        padding: 0.75rem 1rem;
        position: relative;
    }
    
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background-color: transparent;
        border: none;
    }
    
    .nav-tabs .nav-link.active:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #0d6efd;
    }
    
    .badge {
        font-weight: 500;
    }
    
    
");

$this->registerJs("
    // Add Bootstrap Icons CSS
    var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css';
    document.head.appendChild(link);
");
?>
