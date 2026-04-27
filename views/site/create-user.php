<?php

use app\models\UserRoles;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\bootstrap5\ActiveForm */

$this->title = $model->isNewRecord ? 'Register ' : 'Update ' . 'User - ' . Yii::$app->name;;


?>

<div class="user-form bg-white px-3">
    <div class="container-fluid">
        <?php $form = ActiveForm::begin([
            'id' => 'user-form',
            'layout' => 'default',
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <h4 class="mb-5 py-3"><?= $model->isNewRecord ? 'Register ' : 'Update ' ?> User</h4>
        <!-- Row 1 -->
        <div class="row mb-3">
            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'name')->textInput(['maxlength' => 119, 'placeholder' => 'Enter Name']) ?>
            </div>
            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'email')->textInput(['maxlength' => 119, 'type' => 'email', 'placeholder' => 'Enter Email']) ?>
            </div>

            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'phone')->textInput(['maxlength' => 119, 'placeholder' => 'Enter Phone']) ?>
            </div>

            <?php if($model->isNewRecord): ?>
            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => 119, 'placeholder' => 'Enter Password']) ?>
            </div>
            <?php endif; ?>
            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'gender')->dropDownList([
                    'male' => 'Male',
                    'female' => 'Female',
                    'other' => 'Other'
                ], ['prompt' => 'Select Gender']) ?>
            </div>
            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'dob')->widget(DatePicker::class, [
                    'language' => 'en',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control', 'placeholder' => 'Enter Date of Birth'],
                    'clientOptions' => [
                        'changeMonth' => true,
                        'changeYear' => true,
                        'yearRange' => '1900:' . date('Y'),
                    ],
                ]) ?>
            </div>

            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'nationality')->textInput(['maxlength' => 119, 'placeholder' => 'Enter Nationality']) ?>
            </div>
            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'residence')->textInput(['maxlength' => 119, 'placeholder' => 'Enter Residence']) ?>
            </div>

            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'NIN_or_Passport')->textInput(['maxlength' => 119, 'placeholder' => 'Enter NIN or Passport']) ?>
            </div>
            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'role')->dropDownList(ArrayHelper::map(
                    UserRoles::find()->all(), 'id', 'Role',
                ), ['prompt' => 'Select Role']) ?>
            </div>

            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'passportPhoto')->fileInput([
                    'class' => 'form-control',
                    'accept' => 'image/*'
                ]) ?>
            </div>
            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'remember_token')->hiddenInput()->label(false) ?>
            </div>
        </div>

        <div class="form-group text-left mt-4">
            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => 'btn btn-success px-5']) ?>
            <?= Html::a('Cancel', Yii::$app->request->referrer, ['class' => 'btn btn-secondary px-5 ms-2']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
