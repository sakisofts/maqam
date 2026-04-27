<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\MasterPackage */

$this->title = 'Create Package';
?>

<div class="container-fluid bg-white px-4">
        <h1 class="card-title fs-4 my-4"><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin([
            'id' => 'package-form',
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>
        <?= $form->field($model, 'imageFile')->fileInput([
            'class' => 'form-control',
            'accept' => 'image/*'
        ])->hint('Please select an image file. Allowed formats: JPG, PNG, GIF.')->label('Package Image') ?>
        <?= $form->field($model, 'package_name')->textInput(['maxlength' => true, 'class' => 'form-control my-3']) ?>
        <?= $form->field($model, 'reservation_fee')->textInput(['type' => 'number', 'class' => 'form-control my-3']) ?>
        <?= $form->field($model, 'descript')->textarea(['rows' => 4, 'class' => 'form-control'])->label('Description') ?>

        <?php if (!empty($model->package_image)): ?>
            <div class="form-group row mb-3">
                <div class="col-sm-3"></div>
                <div class="col-sm-9">
                    <div class="card" style="max-width: 200px;">
                        <div class="card-header bg-light">Current Image</div>
                        <div class="card-body p-2">
                            <img src="<?= Yii::getAlias('@web/uploads/packages/') . $model->package_image ?>"
                                 class="img-fluid" alt="Current package image">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="form-group row mt-4">
            <div class="col-sm-9 text-left">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary ms-2']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
</div>
