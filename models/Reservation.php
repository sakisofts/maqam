<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "reservation".
 *
 * @property int $id
 * @property string $reservation_number
 * @property int $user_id
 * @property int $package_id
 * @property string $reservation_date
 * @property int $number_of_pilgrims
 * @property string $status
 * @property float $total_amount
 * @property float $amount_paid
 * @property float $balance_due
 * @property string $payment_deadline
 * @property string|null $special_requests
 * @property int $created_at
 * @property int $updated_at
 * @property Packages $package
 * @property User $user
 */
class Reservation extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_PENDING = 'Pending';
    const STATUS_CONFIRMED = 'Confirmed';
    const STATUS_CANCELLED = 'Cancelled';
    const STATUS_COMPLETED = 'Completed';
    const NOW = 'NOW()';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservation';
    }




    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('' . self::NOW . ''),
            ],
            'reservationDateBehavior' => [
                'class' => \yii\behaviors\AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'reservation_date',
                ],
                'value' => new Expression(self::NOW),
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['special_requests'], 'default', 'value' => null],
            [['number_of_pilgrims'], 'default', 'value' => 1],
            [['status'], 'default', 'value' => 'Pending'],
            [['amount_paid'], 'default', 'value' => 0.00],
            [['reservation_number', 'user_id', 'package_id',  'total_amount', 'balance_due', 'payment_deadline'], 'required'],
            [['user_id', 'package_id', 'number_of_pilgrims', 'created_at', 'updated_at'], 'integer'],
            [['reservation_date', 'payment_deadline'], 'safe'],
            [['status', 'special_requests'], 'string'],
            [['total_amount', 'amount_paid', 'balance_due'], 'number'],
            [['reservation_number'], 'string', 'max' => 50],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['reservation_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reservation_number' => 'Reservation Number',
            'user_id' => 'User ID',
            'package_id' => 'Package ID',
            'reservation_date' => 'Reservation Date',
            'number_of_pilgrims' => 'Number Of Pilgrims',
            'status' => 'Status',
            'total_amount' => 'Total Amount',
            'amount_paid' => 'Amount Paid',
            'balance_due' => 'Balance Due',
            'payment_deadline' => 'Payment Deadline',
            'special_requests' => 'Special Requests',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_COMPLETED => 'Completed',
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
    public function isStatusConfirmed()
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    public function setStatusToConfirmed()
    {
        $this->status = self::STATUS_CONFIRMED;
    }

    /**
     * @return bool
     */
    public function isStatusCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function setStatusToCancelled()
    {
        $this->status = self::STATUS_CANCELLED;
    }

    /**
     * @return bool
     */
    public function isStatusCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function setStatusToCompleted()
    {
        $this->status = self::STATUS_COMPLETED;
    }

   public function user(){
        return User::findOne($this->user_id);
   }

   public function package(){
        return MasterPackage::findOne($this->package_id);
   }

    public function beforeSave($insert)
    {
        $this->reservation_date = new Expression(self::NOW);
        $this->created_at = new Expression(self::NOW);
        $this->updated_at = new Expression(self::NOW);
        return parent::beforeSave($insert);
    }


}
