<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "master_package".
 *
 * @property int $id
 * @property string|null $package_name
 * @property string|null $package_image
 * @property string|null $descript
 * @property string|null $created_at
 * @property int|null $reservation_fee
 * @property int|null $created_by
 */
class MasterPackage extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public $imageFile;


    public static function tableName()
    {
        return 'master_package';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_name', 'package_image', 'descript', 'created_at', 'reservation_fee', 'created_by'], 'default', 'value' => null],
            [['created_at'], 'safe'],
            [['reservation_fee', 'created_by'], 'integer'],
            [['package_name', 'package_image', 'descript'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_name' => 'Package Name',
            'package_image' => 'Package Image',
            'descript' => 'Descript',
            'created_at' => 'Created At',
            'reservation_fee' => 'Reservation Fee',
            'created_by' => 'Created By',
        ];
    }


    public function upload()
    {
        if ($this->validate()) {
            if ($this->imageFile) {
                // Create upload directory if it doesn't exist
                $uploadPath = Yii::getAlias('@webroot/uploads/packages');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Generate unique filename
                $fileName = 'package_' . time() . '.' . $this->imageFile->extension;
                $filePath = $uploadPath . '/' . $fileName;

                if ($this->imageFile->saveAs($filePath)) {
                    $this->package_image = $fileName;
                    return true;
                }
            }
            return true; // If no image is uploaded, still return true
        }
        return false;
    }



}
