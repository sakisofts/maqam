<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "packages".
 *
 * @property int $id
 * @property string $category
 * @property string $type
 * @property string|null $description
 * @property string|null $standardPrice
 * @property string|null $economyPrice
 * @property string $title
 * @property string $dateRange
 * @property string $endDateTime
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $packageImage
 * @property string|null $package_year
 * @property int|null $mpId
 * @property int|null $is_archived
 * @property string|null $amenity
 * @property string|null $status
 */
class Packages extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'packages';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'standardPrice', 'economyPrice', 'created_at', 'updated_at', 'packageImage', 'package_year', 'mpId', 'amenity', 'status'], 'default', 'value' => null],
            [['is_archived'], 'default', 'value' => 0],
            [['category', 'type', 'title', 'dateRange', 'endDateTime'], 'required'],
            [['description'], 'string'],
            [['endDateTime', 'created_at', 'updated_at', 'amenity'], 'safe'],
            [['mpId', 'is_archived'], 'integer'],
            [['category', 'type', 'standardPrice', 'economyPrice', 'title', 'dateRange', 'packageImage', 'package_year', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'type' => 'Type',
            'description' => 'Description',
            'standardPrice' => 'Standard Price',
            'economyPrice' => 'Economy Price',
            'title' => 'Title',
            'dateRange' => 'Date Range',
            'endDateTime' => 'End Date Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'packageImage' => 'Package Image',
            'package_year' => 'Package Year',
            'mpId' => 'Mp ID',
            'is_archived' => 'Is Archived',
            'amenity' => 'Amenity',
            'status' => 'Status',
        ];
    }

    public function getMasterPackage(){
        return $this->hasOne(MasterPackage::class, ['id' => 'mpId']);
    }

    public function masterPackage()
    {
        return ArrayHelper::map(MasterPackage::find()->all(), 'id', 'package_name');
    }

    public function Mpk($id){
        return MasterPackage::findOne($id);
    }

}
