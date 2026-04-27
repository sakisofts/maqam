<?php

namespace app\models;
use Yii;
use yii\base\Model;

/**
 * PasswordChangeForm is the model for changing user password
 */
class PasswordChangeForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'confirmPassword'], 'required'],
            ['currentPassword', 'validateCurrentPassword'],
            ['newPassword', 'string', 'min' => 8],
            ['newPassword', 'match', 'pattern' => '/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).*$/',
                'message' => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Passwords do not match.'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'currentPassword' => 'Current Password',
            'newPassword' => 'New Password',
            'confirmPassword' => 'Confirm New Password',
        ];
    }

    /**
     * Validates the current password.
     *
     * @param string $attribute the attribute being validated
     */
    public function validateCurrentPassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->user->identity;

            if (!$user || !$user->validatePassword($this->$attribute)) {
                $this->addError($attribute, 'Current password is incorrect.');
            }
        }
    }

    /**
     * Changes the user's password.
     *
     * @return boolean whether the password was changed successfully
     */
    public function changePassword()
    {
        if ($this->validate()) {
            $user = Yii::$app->user->identity;
            $user->setPassword($this->newPassword);

            return $user->save(false);
        }

        return false;
    }
}
