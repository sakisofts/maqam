<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sonda_mpolas".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $identificationType
 * @property string|null $nin_or_passport
 * @property string|null $dateOfExpiry
 * @property string|null $phone
 * @property string|null $otherPhone
 * @property string|null $email
 * @property string|null $savingFor
 * @property string|null $umrahSavingTarget
 * @property string|null $hajjSavingTarget
 * @property string|null $targetAmount
 * @property integer $balance
 * @property string|null $gender
 * @property string|null $occupation
 * @property string|null $position
 * @property string|null $dob
 * @property string|null $placeOfBirth
 * @property string|null $fatherName
 * @property string|null $motherName
 * @property string|null $maritalStatus
 * @property string|null $country
 * @property string|null $nationality
 * @property string|null $residence
 * @property string|null $district
 * @property string|null $county
 * @property string|null $subcounty
 * @property string|null $parish
 * @property string|null $village
 * @property string|null $nextOfKin
 * @property string|null $relationship
 * @property string|null $nextOfKinAddress
 * @property string|null $mobileNo
 * @property string|null $image
 * @property string|null $reference
 * @property string|null $process_status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $system_user
 */
class SondaMpolas extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sonda_mpolas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'identificationType', 'nin_or_passport', 'dateOfExpiry', 'phone', 'otherPhone', 'email', 'savingFor', 'umrahSavingTarget', 'hajjSavingTarget', 'targetAmount', 'gender', 'occupation', 'position', 'dob', 'placeOfBirth', 'fatherName', 'motherName', 'maritalStatus', 'country', 'nationality', 'residence', 'district', 'county', 'subcounty', 'parish', 'village', 'nextOfKin', 'relationship', 'nextOfKinAddress', 'mobileNo', 'image', 'reference', 'process_status', 'created_at', 'updated_at', 'created_by', 'system_user'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by','balance', 'system_user'], 'integer'],
            [['name', 'identificationType', 'nin_or_passport', 'dateOfExpiry', 'phone', 'otherPhone', 'email', 'savingFor', 'umrahSavingTarget', 'hajjSavingTarget', 'targetAmount', 'gender', 'occupation', 'position', 'dob', 'placeOfBirth', 'fatherName', 'motherName', 'maritalStatus', 'country', 'nationality', 'residence', 'district', 'county', 'subcounty', 'parish', 'village', 'nextOfKin', 'relationship', 'nextOfKinAddress', 'mobileNo', 'image', 'reference', 'process_status'], 'string', 'max' => 255],
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
            'identificationType' => 'Identification Type',
            'nin_or_passport' => 'Nin Or Passport',
            'dateOfExpiry' => 'Date Of Expiry',
            'balance' => 'Balance',
            'phone' => 'Phone',
            'otherPhone' => 'Other Phone',
            'email' => 'Email',
            'savingFor' => 'Saving For',
            'umrahSavingTarget' => 'Umrah Saving Target',
            'hajjSavingTarget' => 'Hajj Saving Target',
            'targetAmount' => 'Target Amount',
            'gender' => 'Gender',
            'occupation' => 'Occupation',
            'position' => 'Position',
            'dob' => 'Dob',
            'placeOfBirth' => 'Place Of Birth',
            'fatherName' => 'Father Name',
            'motherName' => 'Mother Name',
            'maritalStatus' => 'Marital Status',
            'country' => 'Country',
            'nationality' => 'Nationality',
            'residence' => 'Residence',
            'district' => 'District',
            'county' => 'County',
            'subcounty' => 'Subcounty',
            'parish' => 'Parish',
            'village' => 'Village',
            'nextOfKin' => 'Next Of Kin',
            'relationship' => 'Relationship',
            'nextOfKinAddress' => 'Next Of Kin Address',
            'mobileNo' => 'Mobile No',
            'image' => 'Image',
            'reference' => 'Reference',
            'process_status' => 'Process Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'system_user' => 'System User',
        ];
    }

}
