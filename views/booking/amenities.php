<?php

use app\components\Generics\FlashAlertWidget;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/**
 * @var $model \app\models\Amenities
 */
$this->title = $model->isNewRecord ? 'Create Amenity' : 'Update Amenity: ' . $model->amenity;

?>


<?= FlashAlertWidget::widget([
    'duration' => 5000,
    'position' => 'top-right',
    'showCloseButton' => true
]) ?>

<div class="amenity-form container-fluid bg-white p-4">
    <div class="col-12">
        <h1 class="my-4"><?= Html::encode($this->title) ?></h1>
        <div class="mt-3">
            <?php $form = ActiveForm::begin([
                'id' => 'amenity-form',
                'options' => ['class' => 'mt-3'],
            ]); ?>

            <?= $form->field($model, 'amenity')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>

            <?= $form->field($model, 'charges')->textInput(['type' => 'number', 'class' => 'form-control']) ?>

            <div class="form-group mt-4 text-leff">
                <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Cancel', ['amenities'], ['class' => 'btn btn-secondary ms-2']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
