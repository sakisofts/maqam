<?php

namespace app\components\Generics;

use app\models\MasterPackage;
use app\models\User;
use app\models\UserRoles;
use Yii;
use yii\base\Component;


class CrossHelper extends Component
{


    public static function salutation()
    {
        return [
            'Mr.' => 'Mr',
            'Mrs.' => 'Mrs',
            'Ms.' => 'Ms',
            'Eng.' => 'Eng',
        ];
    }

    public static function StaffStatus()
    {
        return [
            'Active' => 'Active',
            'Inactive' => 'Inactive',
            'Suspended' => 'Suspended',
            'Resigned' => 'Resigned',
        ];
    }

    public static function employmentType()
    {
        return [
            'Contract' => 'Contract',
            'Internship' => 'Internship',
            'Temporary' => 'Temporary',
            'Permanent' => 'Permanent',
            'Probationary' => 'Probationary',
        ];
    }

    public static function isLogedin()
    {
        if (Yii::$app->user->isGuest) {
            return yii::$app->user->loginRequired();
        }
        return true;
    }


    public static function customers()
    {
        return User::find()->where(['role' => UserRoles::find()->select('id')->where(['like', 'Role', 'client'])->one()->id])->indexBy('id')->all();
  }

  public static function mPackages(){
        return MasterPackage::find()->select(['id', 'package_name'])->indexBy('id')->all();
  }

    public static function firstUse(): bool
    {
        return Yii::$app->security->validatePassword('@Default@123', self::user()->password_hash);
    }

    public static function user()
    {
        return Yii::$app->user->identity;
    }

    public static function firstLogin()
    {
        $user = User::findOne(self::user()->id);
        return Yii::$app->security->validatePassword('@Default@123', $user->password_hash);

    }

    public static function modelNameResolver($model)
    {
        $ref = new \ReflectionClass($model);

        $name = str_replace('Search', '', $ref->getShortName());
        $spacedEntityName = preg_replace('/(?<!^)[A-Z]/', ' $0', $name);
        $title = ucwords($spacedEntityName) . ' Report';
        $subtitle = 'List of Registered ' . strtolower($spacedEntityName) . 's';
        $filename = strtolower(str_replace(' ', '_', $spacedEntityName)) . '_report';

        return [
            'title' => $title,
            'subtitle' => $subtitle,
            'filename' => $filename
        ];
    }

    public static function  camelCaseToSpaces($camelCaseString) {
        return preg_replace('/(?<!^)([A-Z])/', ' $1', $camelCaseString);
    }

    public static function username($value)
    {
        return User::findOne(['id' => $value])->name;
    }

}
