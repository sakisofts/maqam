<?php

use app\widgets\SearchableDropDown;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model \yii\base\Model
 */
$form = ActiveForm::begin([
    'method' => 'post',
    'options' => ['class' => 'search-form']
]); ?>

<div class="search-fields d-flex flex-wrap align-items-stretch gap-3">
    <?php if (!empty($searchFields)): ?>
        <?php foreach ($searchFields as $field): ?>
            <div class="form-group p-0 m-0">
                <?php if ($field['type'] === 'date'): ?>
                    <?= $form->field($model, $field['name'], [
                        'options' => ['class' => 'form-group mb-0'],
                        'inputOptions' => ['class' => 'form-control h-100', 'placeholder' => $field['placeholder']]
                    ])->input('date')->label(false) ?>
                <?php elseif ($field['type'] === 'select'): ?>
                    <?= $form->field($model, $field['name'])->widget(SearchableDropDown::class,[
                        'data' => $field['options'],
//                        'placeholder' => $field['placeholder'],
                        'options' => ['class' => 'form-control h-100 select2-search', 'placeholder' => $field['placeholder']]
                    ])->label(false) ?>
                <?php elseif ($field['type'] === 'text'): ?>
                    <?= $form->field($model, $field['name'], [
                        'options' => ['class' => 'form-group mb-0'],
                        'inputOptions' => ['class' => 'form-control h-100', 'placeholder' => $field['placeholder']]
                    ])->textInput()->label(false) ?>
                <?php else: ?>
                    <?= $form->field($model, $field['name'], [
                        'options' => ['class' => 'form-group mb-0'],
                        'inputOptions' => ['class' => 'form-control h-100', 'placeholder' => $field['placeholder']]
                    ])->textInput()->label(false) ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<!--    m-0 p-0-->
    <div class="form-group  d-flex align-items-stretch">
        <?= Html::submitButton('<i class="fa fa-search" ></i>', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
