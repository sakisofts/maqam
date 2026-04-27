<?php

use app\components\Generics\CrossHelper;
use app\models\Amenities;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\OneTimeServices */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create One Time Service';

?>

<div class="one-time-services-form container-fluid bg-white p-4">
        <div class="my-3">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'needs-validation'],
                'id' => 'one-time-services-form',
                'enableClientValidation' => true,
            ]); ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <?= $form->field($model, 'client_id')->dropDownList(
                        ArrayHelper::map(CrossHelper::customers(), 'id', 'name'),
                        ['prompt' => 'Select Client', 'class' => 'form-select']
                    )->label('Select Client') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'total_charge')->textInput([
                        'type' => 'number',
                        'class' => 'form-control',
                        'step' => '0.01',
                        'min' => '0'
                    ])->label('Total Charge') ?>
                </div>
            </div>

    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="mb-3">
                    <h5>Pick Service</h5>
                </div>
                <div class="amenities-container">
                    <?= $form->field($model, 'services[]')->checkboxList(Amenities::getAmenitiesForForm(), [
                        'class'=>'custom',
                        'item' => function($index, $label, $name, $checked, $value) {
                            $checked = $checked ? 'checked' : '';
                            return "
                                <div class='amenity-item' style='margin-inline: .6em'>
                                    <div class='form-check custom-checkbox'>
                                        <input type='checkbox' class='form-check-input' name='{$name}' value='{$value}' {$checked} id='service-{$index}'>
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

            <div class="form-group mt-4">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Cancel', ['ots'], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
    </div>

<?php $servicePrice = Url::to(['service-price']);
$js = <<<JS
  let selectedServices = {};

        // Handle checkbox change event
        $('.amenities-container input[type="checkbox"]').on('change', function() {
            const serviceId = $(this).val();
            const isChecked = $(this).is(':checked');

            // Get current total value
            let currentTotal = parseFloat($('#onetimeservices-total_charge').val()) || 0;

            if (isChecked) {
                // Service was checked - get its price and add to total
                $.post(`{$servicePrice}`, {
                    id: serviceId
                }, function(response) {
                    if (response && response.success) {
                        const price = parseFloat(response.price);

                        // Store the price for this service
                        selectedServices[serviceId] = price;
                        // Update total
                        const newTotal = calculateTotal();
                        $('#onetimeservices-total_charge').val(newTotal.toFixed(0));
                    } else {
                        console.error('Error fetching service price:', response.error || 'Unknown error');
                    }
                }, 'json')
                    .fail(function(xhr, status, error) {
                        console.error('AJAX error:', error);
                    });
            } else {
                // Service was unchecked - remove its price from total
                if (selectedServices[serviceId]) {
                    delete selectedServices[serviceId];

                    // Update total
                    const newTotal = calculateTotal();
                    $('#onetimeservices-total_charge').val(newTotal.toFixed(2));
                }
            }
        });

        // Function to calculate total from all selected services
        function calculateTotal() {
            return Object.values(selectedServices).reduce((sum, price) => sum + price, 0);
        }

        // Clear selected services when form is reset
        $('#one-time-services-form').on('reset', function() {
            selectedServices = {};
        });

JS;

$this->registerJs($js);
?>
