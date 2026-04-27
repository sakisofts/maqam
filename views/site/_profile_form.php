<?php
/* @var $profile app\models\UserProfile */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;


?>

<div class="profile-form container-fluid bg-white py-4">
    <?php $form = ActiveForm::begin([
        'id' => 'profile-form',
        'options' => ['enctype' => 'multipart/form-data'],
        'enableAjaxValidation' => true,
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($profile, 'firstName')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($profile, 'lastName')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($profile, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">

            <?= $form->field($profile, 'birthdate')->widget(DatePicker::class, [
                'language' => 'en',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control'],
                'clientOptions' => [
                    'changeYear' => true,
                    'changeMonth' => true,
                    'yearRange' => '1900:' . date('Y'),
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($profile, 'gender')->dropDownList([
                'male' => 'Male',
                'female' => 'Female',
                'other' => 'Other',
            ], ['prompt' => 'Select gender']) ?>
        </div>
        <div class="col-md-6">

            <?= $form->field($profile, 'country_id')->dropDownList([
                'AF' => 'Afghanistan',
                'AL' => 'Albania',
                'DZ' => 'Algeria',
                'AS' => 'American Samoa',
                'AD' => 'Andorra',
                'AO' => 'Angola',
                'AI' => 'Anguilla',
                'AQ' => 'Antarctica',
                'AG' => 'Antigua and Barbuda',
                'AR' => 'Argentina',
                'AM' => 'Armenia',
                'AW' => 'Aruba',
                'AU' => 'Australia',
                'AT' => 'Austria',
                'AZ' => 'Azerbaijan',
                'BS' => 'Bahamas',
                'BH' => 'Bahrain',
                'BD' => 'Bangladesh',
                'BB' => 'Barbados',
                'BY' => 'Belarus',
                'BE' => 'Belgium',
                'BZ' => 'Belize',
                'BJ' => 'Benin',
                'BM' => 'Bermuda',
                'BT' => 'Bhutan',
                'BO' => 'Bolivia',
                'BA' => 'Bosnia and Herzegovina',
                'BW' => 'Botswana',
                'BV' => 'Bouvet Island',
                'BR' => 'Brazil',
                'IO' => 'British Indian Ocean Territory',
                'BN' => 'Brunei Darussalam',
                'BG' => 'Bulgaria',
                'BF' => 'Burkina Faso',
                'BI' => 'Burundi',
                'KH' => 'Cambodia',
                'CM' => 'Cameroon',
                'CA' => 'Canada',
                'CV' => 'Cape Verde',
                'KY' => 'Cayman Islands',
                'CF' => 'Central African Republic',
                'TD' => 'Chad',
                'CL' => 'Chile',
                'CN' => 'China',
                'CX' => 'Christmas Island',
                'CC' => 'Cocos (Keeling) Islands',
                'CO' => 'Colombia',
                'KM' => 'Comoros',
                'CG' => 'Congo',
                'CD' => 'Congo, Democratic Republic',
                'CK' => 'Cook Islands',
                'CR' => 'Costa Rica',
                'CI' => 'Cote D\'Ivoire',
                'HR' => 'Croatia',
                'CU' => 'Cuba',
                'CY' => 'Cyprus',
                'CZ' => 'Czech Republic',
                'DK' => 'Denmark',
                'DJ' => 'Djibouti',
                'DM' => 'Dominica',
                'DO' => 'Dominican Republic',
                'EC' => 'Ecuador',
                'EG' => 'Egypt',
                'SV' => 'El Salvador',
                'GQ' => 'Equatorial Guinea',
                'ER' => 'Eritrea',
                'EE' => 'Estonia',
                'ET' => 'Ethiopia',
                'FK' => 'Falkland Islands (Malvinas)',
                'FO' => 'Faroe Islands',
                'FJ' => 'Fiji',
                'FI' => 'Finland',
                'FR' => 'France',
                'GF' => 'French Guiana',
                'PF' => 'French Polynesia',
                'TF' => 'French Southern Territories',
                'GA' => 'Gabon',
                'GM' => 'Gambia',
                'GE' => 'Georgia',
                'DE' => 'Germany',
                'GH' => 'Ghana',
                'GI' => 'Gibraltar',
                'GR' => 'Greece',
                'GL' => 'Greenland',
                'GD' => 'Grenada',
                'GP' => 'Guadeloupe',
                'GU' => 'Guam',
                'GT' => 'Guatemala',
                'GN' => 'Guinea',
                'GW' => 'Guinea-Bissau',
                'GY' => 'Guyana',
                'HT' => 'Haiti',
                'HM' => 'Heard Island & Mcdonald Islands',
                'VA' => 'Holy See (Vatican City State)',
                'HN' => 'Honduras',
                'HK' => 'Hong Kong',
                'HU' => 'Hungary',
                'IS' => 'Iceland',
                'IN' => 'India',
                'ID' => 'Indonesia',
                'IR' => 'Iran, Islamic Republic Of',
                'IQ' => 'Iraq',
            ],
                ['prompt' => 'Select country']
            )->label('Select Country') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($profile, 'address')->textarea(['rows' => 2]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($profile, 'city')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($profile, 'postal_code')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($profile, 'bio')->textarea(['rows' => 4]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($profile, 'avatar')->fileInput(['accept' => 'image/*']) ?>
            <?php if (!empty($profile->avatar)): ?>
                <div class="help-block">Current avatar:
                    <?= Html::img($profile->getAvatarUrl(), ['style' => 'height: 50px;']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-group text-text">
        <?= Html::submitButton('<i class="fa fa-save text-white"></i> Save Profile', ['class' => 'btn btn-success btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
