<?php
/* @var $this yii\web\View */
/* @var $model app\models\Booking */
/* @var $form yii\widgets\ActiveForm */

use app\components\Generics\CrossHelper;
use app\models\Packages;
use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\JsExpression;

$this->title = $model->isNewRecord ? 'Create Booking' : 'Update Booking';
?>

<div class="bg-white container-fluid p-4">
    <div class="panel panel-default">
        <div class="panel-heading pb-4">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'id' => 'booking-form',
//                'enableAjaxValidation' => true,
//                'enableClientValidation' => true,
                'validateOnSubmit' => true,
            ]); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'userId')->widget(Select2::class, [
                        'data' => ArrayHelper::map(CrossHelper::customers(), 'id', function($model) {
                            return $model->name . ' (' . $model->email . ')';
                        }),
                        'options' => ['placeholder' => 'Select a user...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Select User') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'packageId')->widget(Select2::class, [
                        'data' => ArrayHelper::map(Packages::find()->all(), 'id', 'title'),
                        'options' => ['placeholder' => 'Select a package...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'bookingType')->dropDownList([
                        'individual' => 'Individual',
                        'group' => 'Group',
                        'family' => 'Family'
                    ], ['prompt' => 'Select booking type']) ?>
                </div>
            </div>

            <div class="form-group text-left">
                <?= Html::submitButton($model->isNewRecord ? 'Create Booking' : 'Update', ['class' => 'btn btn-success btn-lg']) ?>
                <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default btn-lg']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!--<script>-->
<!--    $(document).ready(function() {-->
<!--        $('#booking-form').on('beforeSubmit', function() {-->
<!--            $(this).find(':submit').prop('disabled', true).text('Processing...');-->
<!--            return true;-->
<!--        });-->
<!--    });-->
<!--</script>-->
