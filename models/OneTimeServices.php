<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "oneTimeServices".
 *
 * @property int $id
 * @property int|null $client_id
 * @property string|null $services
 * @property int|null $total_charge
 * @property string $status
 * @property string|null $created_at
 * @property int|null $created_by
 */
class OneTimeServices extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_PENDING = 'Pending';
    const STATUS_PAID = 'Paid';
    const STATUS_CLOSED = 'Closed';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oneTimeServices';
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
                'class'=>BlameableBehavior::class,
                'createdByAttribute'=>'created_by',
                'updatedByAttribute'=>false,
                'value'=>Yii::$app->user->identity->id,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'services', 'total_charge', 'created_at', 'created_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'Pending'],
            [['client_id', 'total_charge', 'created_by'], 'integer'],
            [['services', 'create_at'], 'safe'],
            [['status'], 'string'],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'services' => 'Services',
            'total_charge' => 'Total Charge',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PAID => 'Paid',
            self::STATUS_CLOSED => 'Closed',
        ];
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function setStatusToPending()
    {
        $this->status = self::STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isStatusPaid()
    {
        return $this->status === self::STATUS_PAID;
    }

    public function setStatusToPaid()
    {
        $this->status = self::STATUS_PAID;
    }

    /**
     * @return bool
     */
    public function isStatusClosed()
    {
        return $this->status === self::STATUS_CLOSED;
    }

    public function setStatusToClosed()
    {
        $this->status = self::STATUS_CLOSED;
    }
}
