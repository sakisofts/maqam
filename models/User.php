<?php

namespace app\models;

use Yii;
/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $email_verified_at
 * @property string|null $password
 * @property int $role
 * @property string|null $gender
 * @property string|null $dob
 * @property string|null $nationality
 * @property string|null $residence
 * @property string|null $NIN_or_Passport
 * @property string|null $passportPhoto
 * @property string|null $remember_token
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $status
 * @property int|null $two_factor_enabled
 * @property string|null $password_changed_at
 * @property string|null $email_change_token
 * @property int|null $notify_login
 * @property int|null $notify_updates
 * @property int|null $notify_news
 * @property string|null $new_email
 * @property int|null $web_notify_login
 * @property int|null $web_notify_updates
 * @property int|null $web_notify_messages
 * @property int|null $web_notify_news
 * @property int|null $push_notify_login
 * @property int|null $push_notify_updates
 * @property int|null $push_notify_messages
 * @property int|null $push_notify_news
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
    }

    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'email_verified_at', 'password', 'gender', 'dob', 'nationality', 'residence', 'NIN_or_Passport', 'passportPhoto', 'remember_token', 'created_at', 'updated_at', 'email_change_token', 'new_email'], 'default', 'value' => null],
            [['push_notify_news'], 'default', 'value' => 0],
            [['email_verified_at', 'created_at', 'updated_at', 'password_changed_at'], 'safe'],
            [['role'], 'required'],
            [['role', 'status', 'two_factor_enabled', 'notify_login', 'notify_updates', 'notify_news', 'web_notify_login', 'web_notify_updates', 'web_notify_messages', 'web_notify_news', 'push_notify_login', 'push_notify_updates', 'push_notify_messages', 'push_notify_news'], 'integer'],
            [['name', 'email', 'phone', 'password', 'gender', 'dob', 'nationality', 'residence', 'NIN_or_Passport', 'passportPhoto'], 'string', 'max' => 119],
            [['remember_token'], 'string', 'max' => 100],
            [['email_change_token', 'new_email'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['phone'], 'unique'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'email_verified_at' => 'Email Verified At',
            'password' => 'Password',
            'role' => 'Role',
            'gender' => 'Gender',
            'dob' => 'Dob',
            'nationality' => 'Nationality',
            'residence' => 'Residence',
            'NIN_or_Passport' => 'Nin Or Passport',
            'passportPhoto' => 'Passport Photo',
            'remember_token' => 'Remember Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'two_factor_enabled' => 'Two Factor Enabled',
            'password_changed_at' => 'Password Changed At',
            'email_change_token' => 'Email Change Token',
            'notify_login' => 'Notify Login',
            'notify_updates' => 'Notify Updates',
            'notify_news' => 'Notify News',
            'new_email' => 'New Email',
            'web_notify_login' => 'Web Notify Login',
            'web_notify_updates' => 'Web Notify Updates',
            'web_notify_messages' => 'Web Notify Messages',
            'web_notify_news' => 'Web Notify News',
            'push_notify_login' => 'Push Notify Login',
            'push_notify_updates' => 'Push Notify Updates',
            'push_notify_messages' => 'Push Notify Messages',
            'push_notify_news' => 'Push Notify News',
        ];
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return null;
    }

    public function validatePassword($password)
    {
        return yii::$app->getSecurity()->validatePassword($password, $this->password);
//        return yii::$app->security->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
//            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }
        return parent::beforeSave($insert);

    }



}
