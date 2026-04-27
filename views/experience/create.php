<?php

declare(strict_types=1);

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/**
 * @var \yii\web\View $this
 * @var \app\models\Video $model
 */

$this->title = $model->isNewRecord ? 'Create Video' : 'Update Video: ' . $model->id;
?>

<div class="container-fluid bg-white p-4">
    <h1 class="fs-4 mb-4"><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin([
        'id' => 'video-form',
        'options' => [
            'class' => 'needs-validation',
            'enctype' => 'multipart/form-data' // Important for file uploads
        ],
        'validateOnSubmit' => true,
    ]); ?>

    <div class="mb-3">
        <?= $form->field($model, 'thumbnail')->fileInput([
            'class' => 'form-control',
            'accept' => 'image/*'
        ])->hint('Upload a thumbnail image for the video') ?>

        <?php if (!$model->isNewRecord && $model->thumbnail): ?>
            <div class="mt-2">
                <label class="form-label">Current Thumbnail:</label>
                <div class="mb-2">
                    <img src="<?= Html::encode($model->thumbnail) ?>"
                         alt="Current thumbnail"
                         class="img-thumbnail"
                         style="max-height: 150px;">
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'videoLink')
            ->textInput(['maxlength' => 1000, 'class' => 'form-control', 'placeholder' => 'Enter video URL'])
            ->hint('Link to the video (YouTube, Vimeo, or other supported platform)') ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'description')
            ->textInput(['maxlength' => 255, 'class' => 'form-control', 'placeholder' => 'Enter a brief description'])
            ->hint('Short description for the video (max 255 characters)') ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'detail')
            ->textarea(['rows' => 6, 'class' => 'form-control', 'placeholder' => 'Enter detailed information'])
            ->hint('Detailed information about the video') ?>
    </div>

    <div class="form-group d-flex justify-content-start gap-3 mt-4">
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

