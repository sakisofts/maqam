<?php

use kartik\daterange\DateRangePicker;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/**
 * @var $model app/models/Package
 * @var $amenities array
 */

$this->title = 'Create Package';
?>



<div class="package-form container-fluid bg-white p-4">
    <h2 class="py-4">Create Package</h2>
    <?php

    $form = ActiveForm::begin([
        'id' => 'package-form',
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'mpId')->dropDownList($model->masterPackage(), ['prompt' => 'Select Package'])->label('Master Package') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'category')->dropDownList([
                'vacation' => 'Vacation',
                'tour' => 'Tour',
                'event' => 'Event',
                'adventure' => 'Adventure',
                // Add more categories as needed
            ], ['prompt' => 'Select Category']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'type')->dropDownList([
                'individual' => 'Individual',
                'group' => 'Group',
                'family' => 'Family',
                'corporate' => 'Corporate',
                // Add more types as needed
            ], ['prompt' => 'Select Type']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'dateRange')->widget(DateRangePicker::class, [
                'convertFormat' => true,
                'pluginOptions' => [
                    'timePicker' => false,
                    'locale' => [
                        'format' => 'Y-m-d'
                    ]
                ]
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'endDateTime')->textInput(['type' => 'date']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'package_year')->widget(\yii\jui\DatePicker::class, [
                'language' => 'en',
                'dateFormat' => 'yyyy',
                'options' => ['class' => 'form-control'],
                'clientOptions' => [
                    'changeYear' => true,
                    'yearRange' => '2000:+10',
                    'showMonthAfterYear' => true,
                    'changeMonth' => false,
                    'showButtonPanel' => true,
                    'onClose' => new \yii\web\JsExpression('function(dateText, inst) { 
                        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                        $(this).datepicker("setDate", new Date(year, 1, 1));
                    }')
                ]
            ])->label('Year') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'standardPrice')->textInput(['type' => 'number', 'step' => '0.01'])->label('Price') ?>
        </div>
        <div class="col-md-4">
            <!-- Empty columns to maintain the grid -->
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="mb-3">
                    <h5>Package Amenities</h5>
                </div>
                    <div class="amenities-container">
                        <?= $form->field($model, 'amenity[]')->checkboxList($amenities, [
                             'class'=>'custom',
                            'item' => function($index, $label, $name, $checked, $value) {
                                $checked = $checked ? 'checked' : '';
                                return "
                                <div class='amenity-item' style='margin-inline: .6em'>
                                    <div class='form-check custom-checkbox'>
                                        <input type='checkbox' class='form-check-input' name='{$name}' value='{$value}' {$checked} id='amenity-{$index}'>
                                        <label class='form-check-label' for='amenity-{$index}'>
                                            <i class='bi bi-check-circle-fill me-2'></i>{$label}
                                        </label>
                                    </div>
                                </div>
                            ";
                            }
                        ])->label(false) ?>
                    </div>
            </div>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary ms-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
