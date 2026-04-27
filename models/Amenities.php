<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "amenities".
 *
 * @property int $id
 * @property string|null $amenity
 * @property int|null $created_by
 * @property string|null $created_at
 * @property int|null $charges
 */
class Amenities extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'amenities';
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
                'value' => Yii::$app->user->identity->id,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amenity', 'created_by', 'created_at'], 'default', 'value' => null],
            [['charges'], 'default', 'value' => 0],
            [['created_by', 'charges'], 'integer'],
            [['created_at'], 'safe'],
            [['amenity'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amenity' => 'Amenity',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'charges' => 'Charges',
        ];
    }

    public static function getAmenitiesForForm()
    {
        $amenities = [];
        $records = self::find()
            ->select(['id', 'amenity'])
            ->orderBy(['amenity' => SORT_ASC])
            ->asArray()
            ->all();
        foreach ($records as $record) {
            $key = self::generateKeyFromAmenity($record['amenity']);
            $amenities[$key] = $record['amenity'];
        }
        return $amenities;
    }

    private static function generateKeyFromAmenity($amenity)
    {
        if (empty(trim($amenity))) {
            return 'amenity' . substr(md5(microtime()), 0, 6);
        }
//        $ucwords = ucwords($amenity);
        return lcfirst(str_replace(' ', '', ucwords($amenity)));
    }

}
