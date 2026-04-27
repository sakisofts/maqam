<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property string $firstName
 * @property string $lastName
 * @property string|null $phone
 * @property string|null $birthdate
 * @property string|null $gender
 * @property int|null $country_id
 * @property string|null $address
 * @property string|null $city
 * @property string|null $postal_code
 * @property string|null $bio
 * @property string|null $avatar
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $userId
 */
class UserProfile extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_OTHER = 'other';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'birthdate', 'gender', 'country_id', 'address', 'city', 'postal_code', 'bio', 'avatar', 'userId'], 'default', 'value' => null],
            [['firstName', 'lastName'], 'required'],
            [['birthdate', 'created_at', 'updated_at'], 'safe'],
            [['gender', 'address', 'bio'], 'string'],
            [['country_id', 'userId'], 'integer'],
            [['firstName', 'lastName', 'avatar'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['city'], 'string', 'max' => 100],
            [['postal_code'], 'string', 'max' => 20],
            ['gender', 'in', 'range' => array_keys(self::optsGender())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'phone' => 'Phone',
            'birthdate' => 'Birthdate',
            'gender' => 'Gender',
            'country_id' => 'Country ID',
            'address' => 'Address',
            'city' => 'City',
            'postal_code' => 'Postal Code',
            'bio' => 'Bio',
            'avatar' => 'Avatar',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'userId' => 'User ID',
        ];
    }


    /**
     * column gender ENUM value labels
     * @return string[]
     */
    public static function optsGender()
    {
        return [
            self::GENDER_MALE => 'male',
            self::GENDER_FEMALE => 'female',
            self::GENDER_OTHER => 'other',
        ];
    }

    /**
     * @return string
     */
    public function displayGender()
    {
        return self::optsGender()[$this->gender];
    }

    /**
     * @return bool
     */
    public function isGenderMale()
    {
        return $this->gender === self::GENDER_MALE;
    }

    public function setGenderToMale()
    {
        $this->gender = self::GENDER_MALE;
    }

    /**
     * @return bool
     */
    public function isGenderFemale()
    {
        return $this->gender === self::GENDER_FEMALE;
    }

    public function setGenderToFemale()
    {
        $this->gender = self::GENDER_FEMALE;
    }

    /**
     * @return bool
     */
    public function isGenderOther()
    {
        return $this->gender === self::GENDER_OTHER;
    }

    public function setGenderToOther()
    {
        $this->gender = self::GENDER_OTHER;
    }
}
