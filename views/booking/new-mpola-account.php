<?php
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Account Registration';
?>

<div class="customer-registration-form">
    <div class="bg-white shadow-sm rounded-3 p-4">
        <div class="text-white">
            <h3 class="text-primary"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="">
            <?php $form = ActiveForm::begin([
                'id' => 'customer-registration-form',
                'options' => ['enctype' => 'multipart/form-data', 'class' => 'needs-validation'],
            ]); ?>

            <div class="wizard">
                <!-- Form Tab Navigation -->
                <div class="wizard-inner mb-4">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="nav-item">
                            <a href="#step1" data-bs-toggle="tab" aria-controls="step1" role="tab"
                               title="Personal Information" class="nav-link active">
                                <span class="round-tab">1</span>
                                <span class="step-label">Personal Information</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#step2" data-bs-toggle="tab" aria-controls="step2" role="tab"
                               title="Contact Details" class="nav-link disabled">
                                <span class="round-tab">2</span>
                                <span class="step-label">Contact Details</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#step3" data-bs-toggle="tab" aria-controls="step3" role="tab"
                               title="Identification" class="nav-link disabled">
                                <span class="round-tab">3</span>
                                <span class="step-label">Identification</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#step4" data-bs-toggle="tab" aria-controls="step4" role="tab" title="Address"
                               class="nav-link disabled">
                                <span class="round-tab">4</span>
                                <span class="step-label">Address</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#step5" data-bs-toggle="tab" aria-controls="step5" role="tab" title="Next of Kin"
                               class="nav-link disabled">
                                <span class="round-tab">5</span>
                                <span class="step-label">Next of Kin</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#step6" data-bs-toggle="tab" aria-controls="step6" role="tab"
                               title="Savings Information" class="nav-link disabled">
                                <span class="round-tab">6</span>
                                <span class="step-label">Savings Information</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <?=$this->render('_stape_labels')?>

                <!-- Form Content -->
                <div class="tab-content mt-5">
                    <!-- Step 1: Personal Information -->
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your full name'])->label('Full Name') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'gender')->dropDownList(
                                    ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'],
                                    ['prompt' => 'Select your gender', 'class' => 'form-select']
                                ) ?>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <?= $form->field($model, 'dob')->widget(\yii\jui\DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Enter your date of birth', 'class' => 'form-control'],
                                    'dateFormat' => 'yyyy-MM-dd',
                                    'clientOptions' => [
                                        'maxDate' => 'today'
                                    ]
                                ])->label('Date of Birth') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'placeOfBirth')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your place of birth'])->label('Place of Birth') ?>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <?= $form->field($model, 'fatherName')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your father\'s name'])->label('Father\'s Name') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'motherName')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your mother\'s name'])->label('Mother\'s Name') ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-start mt-4">
                            <button type="button" class="btn btn-primary next-step">Next <i
                                        class="bi bi-arrow-right ms-1"></i></button>
                        </div>
                    </div>

                    <!-- Step 2: Contact Details -->
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your primary phone number'])->label('Primary Phone Number') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'otherPhone')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your alternative phone number (optional)'])->label('Alternative Phone Number') ?>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your email address'])->label('Email Address') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'nationality')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your nationality'])->label('Nationality') ?>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <?= $form->field($model, 'occupation')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your occupation'])->label('Occupation') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'position')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your position'])->label('Position') ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-start gap-2 mt-4">
                            <button type="button" class="btn btn-secondary prev-step"><i
                                        class="bi bi-arrow-left me-1"></i> Previous
                            </button>
                            <button type="button" class="btn btn-primary next-step">Next <i
                                        class="bi bi-arrow-right ms-1"></i></button>
                        </div>
                    </div>

                    <!-- Step 3: Identification -->
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <?= $form->field($model, 'identificationType')->dropDownList(
                                    ['NIN' => 'National ID', 'Passport' => 'Passport', 'Driving License' => 'Driving License', 'Other' => 'Other'],
                                    ['prompt' => 'Select identification type', 'class' => 'form-select']
                                )->label('Identification Type') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'nin_or_passport')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your ID number'])->label('ID Number') ?>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <?= $form->field($model, 'dateOfExpiry')->widget(\yii\jui\DatePicker::className(), [
                                    'options' => ['placeholder' => 'Enter expiry date of your ID', 'class' => 'form-control'],
                                    'dateFormat' => 'yyyy-MM-dd',
                                    'clientOptions' => [
                                        'minDate' => date('Y-m-d'),
                                        'changeYear' => true,
                                        'changeMonth' => true
                                    ]
                                ])->label('Date of Expiry') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'image')->fileInput(['class' => 'form-control'])->label('Upload ID Image') ?>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <?= $form->field($model, 'maritalStatus')->dropDownList(
                                    ['Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced', 'Widowed' => 'Widowed'],
                                    ['prompt' => 'Select your marital status', 'class' => 'form-select']
                                )->label('Marital Status') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'reference')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter reference number if any'])->label('Reference Number') ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-start gap-2 mt-4">
                            <button type="button" class="btn btn-secondary prev-step"><i
                                        class="bi bi-arrow-left me-1"></i> Previous
                            </button>
                            <button type="button" class="btn btn-primary next-step">Next <i
                                        class="bi bi-arrow-right ms-1"></i></button>
                        </div>
                    </div>

                    <!-- Step 4: Address Details -->
                    <div class="tab-pane" role="tabpanel" id="step4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <?= $form->field($model, 'country')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your country'])->label('Country') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'residence')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your current residence'])->label('Current Residence') ?>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <?= $form->field($model, 'district')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your district'])->label('District') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'county')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your county'])->label('County') ?>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <?= $form->field($model, 'subcounty')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your subcounty'])->label('Subcounty') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'parish')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your parish'])->label('Parish') ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-start gap-2 mt-4">
                            <button type="button" class="btn btn-secondary prev-step"><i
                                        class="bi bi-arrow-left me-1"></i> Previous
                            </button>
                            <button type="button" class="btn btn-primary next-step">Next <i
                                        class="bi bi-arrow-right ms-1"></i></button>
                        </div>
                    </div>

                    <!-- Step 5: Next of Kin -->
                    <div class="tab-pane" role="tabpanel" id="step5">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <?= $form->field($model, 'nextOfKin')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter name of your next of kin'])->label('Next of Kin Name') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'relationship')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your relationship with next of kin'])->label('Relationship') ?>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <?= $form->field($model, 'nextOfKinAddress')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter address of your next of kin'])->label('Next of Kin Address') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'mobileNo')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter mobile number of your next of kin'])->label('Next of Kin Mobile Number') ?>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <?= $form->field($model, 'village')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your village'])->label('Village') ?>
                            </div>
                            <div class="col-md-6">
                                <!-- Extra field slot if needed -->
                            </div>
                        </div>

                        <div class="d-flex justify-content-start gap-2 mt-4">
                            <button type="button" class="btn btn-secondary prev-step"><i
                                        class="bi bi-arrow-left me-1"></i> Previous
                            </button>
                            <button type="button" class="btn btn-primary next-step">Next <i
                                        class="bi bi-arrow-right ms-1"></i></button>
                        </div>
                    </div>

                    <!-- Step 6: Savings Information -->
                    <div class="tab-pane" role="tabpanel" id="step6">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <?= $form->field($model, 'savingFor')->dropDownList(
                                    ['Umrah' => 'Umrah', 'Hajj' => 'Hajj', 'Other' => 'Other'],
                                    ['prompt' => 'Select saving purpose', 'class' => 'form-select', 'id' => 'saving-purpose']
                                )->label('Saving Purpose') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'targetAmount')->textInput(['type' => 'number', 'class' => 'form-control', 'placeholder' => 'Enter your target amount'])->label('Target Amount') ?>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6 umrah-field" style="display: none;">
                                <?= $form->field($model, 'umrahSavingTarget')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your Umrah saving target'])->label('Umrah Saving Target') ?>
                            </div>
                            <div class="col-md-6 hajj-field" style="display: none;">
                                <?= $form->field($model, 'hajjSavingTarget')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter your Hajj saving target'])->label('Hajj Saving Target') ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-start gap-2 mt-4">
                            <button type="button" class="btn btn-secondary prev-step"><i
                                        class="bi bi-arrow-left me-1"></i> Previous
                            </button>
                            <?= Html::submitButton('Submit Registration', ['class' => 'btn btn-success', 'id' => 'submit-btn']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$script = <<<JS
$(document).ready(function () {
    // Form navigation
    $('.next-step').click(function () {
        var activeTab = $('.tab-pane.active');
        var nextTab = activeTab.next('.tab-pane');
        
        if (nextTab.length > 0) {
            // Hide current tab
            activeTab.removeClass('active');
            
            // Show next tab
            nextTab.addClass('active');
            
            // Hide current step description and show next
            $('#' + activeTab.attr('id') + '-description').hide();
            $('#' + nextTab.attr('id') + '-description').show();
            
            // Update nav tabs
            var currentLink = $('.nav-tabs a[href="#' + activeTab.attr('id') + '"]');
            var nextLink = $('.nav-tabs a[href="#' + nextTab.attr('id') + '"]');
            
            currentLink.removeClass('active');
            nextLink.removeClass('disabled').addClass('active');
            
            // Scroll to top of form if needed
            $('html, body').animate({
                scrollTop: $('.wizard').offset().top - 50
            }, 500);
        }
    });
    
    $('.prev-step').click(function () {
        var activeTab = $('.tab-pane.active');
        var prevTab = activeTab.prev('.tab-pane');
        
        if (prevTab.length > 0) {
            // Hide current tab
            activeTab.removeClass('active');
            
            // Show previous tab
            prevTab.addClass('active');
            
            // Hide current step description and show previous
            $('#' + activeTab.attr('id') + '-description').hide();
            $('#' + prevTab.attr('id') + '-description').show();
            
            // Update nav tabs
            var currentLink = $('.nav-tabs a[href="#' + activeTab.attr('id') + '"]');
            var prevLink = $('.nav-tabs a[href="#' + prevTab.attr('id') + '"]');
            
            currentLink.removeClass('active');
            prevLink.addClass('active');
            
            // Scroll to top of form if needed
            $('html, body').animate({
                scrollTop: $('.wizard').offset().top - 50
            }, 500);
        }
    });
    
    // Tab click handling
    $('.nav-tabs a').on('click', function(e) {
        // Only proceed if link is not disabled
        if (!$(this).hasClass('disabled')) {
            // Get target tab
            var targetTab = $(this).attr('href');
            
            // Hide all tabs
            $('.tab-pane').removeClass('active');
            
            // Show target tab
            $(targetTab).addClass('active');
            
            // Hide all step descriptions
            $('.step-description').hide();
            
            // Show corresponding step description
            $(targetTab + '-description').show();
            
            // Update nav tabs
            $('.nav-tabs a').removeClass('active');
            $(this).addClass('active');
        }
        e.preventDefault();
    });
    
    // Saving purpose conditional fields
    $('#saving-purpose').change(function() {
        var selectedOption = $(this).val();
        
        // Hide all conditional fields first
        $('.umrah-field, .hajj-field').hide();
        
        // Show relevant fields based on selection
        if (selectedOption === 'Umrah') {
            $('.umrah-field').show();
        } else if (selectedOption === 'Hajj') {
            $('.hajj-field').show();
        }
    });
});
JS;

$this->registerJs($script);
?>
<style>
    .wizard {
        margin: 20px auto;
        background: #fff;
    }

    .wizard-inner {
        position: relative;
        padding: 5px 0;
        margin-bottom: 20px;
    }

    .connecting-line {
        height: 3px;
        background: #e0e0e0;
        position: absolute;
        width: 80%;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: 50%;
        z-index: 1;
    }

    .wizard .nav-tabs {
        position: relative;
        margin: 0 auto;
        border-bottom: none;
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .wizard .nav-tabs .nav-item {
        flex: 1;
        text-align: center;
    }

    .wizard .nav-tabs > li > a {
        display: flex;
        flex-direction: column;
        align-items: center;
        border: none;
        color: #555;
        position: relative;
        padding: 15px 0;
    }

    span.round-tab {
        width: 40px;
        height: 40px;
        line-height: 38px;
        display: inline-block;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #e0e0e0;
        z-index: 2;
        text-align: center;
        font-size: 16px;
        color: #555;
        margin-bottom: 5px;
        position: relative;
    }

    .nav-link.active span.round-tab {
        background: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
    }

    .nav-link.disabled span.round-tab {
        background: #f8f9fa;
        color: #6c757d;
    }

    .nav-link.completed span.round-tab {
        background: #28a745;
        border-color: #28a745;
        color: #fff;
    }

    .step-label {
        font-size: 12px;
        color: #555;
        margin-top: 5px;
        display: block;
        text-align: center;
        width: 100%;
    }

    .nav-link.active .step-label {
        color: #0d6efd;
        font-weight: bold;
    }


    .current-step-description h4 {
        color: #0d6efd;
        margin-bottom: 5px;
    }

    /* Make the form responsive */
    @media (max-width: 767px) {
        .step-label {
            display: none;
        }

        .connecting-line {
            width: 70%;
        }

        span.round-tab {
            width: 30px;
            height: 30px;
            line-height: 28px;
            font-size: 14px;
        }
    }
</style>
