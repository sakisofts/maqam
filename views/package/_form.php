<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\MasterPackage */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="package-form">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <?= Alert::widget([
            'options' => ['class' => 'alert-success'],
            'body' => Yii::$app->session->getFlash('success'),
        ]); ?>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <?= Alert::widget([
            'options' => ['class' => 'alert-danger'],
            'body' => Yii::$app->session->getFlash('error'),
        ]); ?>
    <?php endif; ?>

    <?php $form = ActiveForm::begin([
        'id' => 'package-form',
        'options' => ['enctype' => 'multipart/form-data'],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-3 col-form-label',
                'wrapper' => 'col-sm-9',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'package_name')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>

    <?= $form->field($model, 'descript')->textarea(['rows' => 4, 'class' => 'form-control']) ?>

    <?= $form->field($model, 'reservation_fee')->textInput(['type' => 'number', 'class' => 'form-control']) ?>

    <?= $form->field($model, 'imageFile')->fileInput([
        'class' => 'form-control',
        'accept' => 'image/*'
    ])->hint('Please select an image file. Allowed formats: JPG, PNG, GIF.') ?>

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
        <div class="col-sm-9 offset-sm-3">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary ms-2']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
