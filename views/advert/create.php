<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Card;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\YourModel */
/* @var $form yii\bootstrap5\ActiveForm */

$this->title = 'Create New Item';
?>

<div class="container-fluid py-4 px-4 bg-white">

    <div class="pb-3 text-primary">
        <h1 class="fs-4 mb-0"><?= Html::encode($this->title) ?></h1>
    </div>
    <?php $form = ActiveForm::begin([
        'id' => 'item-form',
        'options' => ['enctype' => 'multipart/form-data'],

    ]); ?>


    <div class="mb-3">
        <?= $form->field($model, 'title')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => 'Enter title'
        ]) ?>
    </div>
    <div class="mb-3">
        <?= $form->field($model, 'image')->fileInput([
            'class' => 'form-control',
            'accept' => 'image/*'
        ])->hint('Upload an image file.') ?>
    </div>
    <div class="mb-3">
        <?= $form->field($model, 'description')->textarea([
            'rows' => 4,
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => 'Enter description'
        ]) ?>
    </div>


    <div class="mb-3">
        <?= $form->field($model, 'endDateTime')->widget(DatePicker::class, [
            'options' => [
                'class' => 'form-control',
                'placeholder' => 'Select end date and time'
            ],
            'dateFormat' => 'php:Y-m-d H:i:s',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
                'showTime' => true,
            ],
        ]) ?>
    </div>

    <div class="form-group d-flex justify-content-start
         mt-4">
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary me-2']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
