<?php
/* @var $this yii\web\View */
/* @var $model app\models\LoginForm */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Login - '.Yii::$app->name;
?>
<div class="login-container">
    <div class="login-header">
        <div class="text-center mb-2">
            <a href="<?=Url::to(['/'])?>">
                <img src="<?=Url::to(['web/front/imgs/logo.png'])?>" width="50px" height="50px" alt="The sacred journey starts with us, we take you there">
            </a>
        </div>
        <h1 class="login-title">Login to Your Account</h1>
        <p class="login-subtitle">Enter your Email & password to login</p>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'login-form'],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'form-label'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'text-danger'],
        ],
    ]); ?>

    <div class="form-group">
        <?= $form->field($model, 'username')->label('Email')->textInput([
            'placeholder' => 'Enter your email',
//            'autofocus' => true,
            'template' => '
                <label class="form-label">Email</label>
                <div class="input-group">
                    <div class="input-group-prepend">@</div>
                    {input}
                </div>
                {error}
            '
        ]) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'password')->passwordInput([
            'placeholder' => 'Enter your password',
            'template' => '
                <label class="form-label">Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">🔒</div>
                    {input}
                </div>
                {error}
            '
        ])->label('Password') ?>
    </div>

    <div class="remember-me">
        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => '<div class="custom-control custom-checkbox">{input} {label}</div>{error}',
            'labelOptions' => ['class' => ''],
        ])->label('Remember me') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn-login', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
