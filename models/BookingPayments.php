<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "booking_payments".
 *
 * @property int $id
 * @property int $bookingId
 * @property string|null $amount
 * @property string|null $payment_status
 * @property string|null $paymentOption
 * @property string|null $currency
 * @property string|null $rate
 * @property string|null $actual_amount
 * @property string|null $transaction_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $issuedBy
 */
class BookingPayments extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'booking_payments';
    }

//    public function behaviors()
//    {
//        return [
//          'class' => TimeStampBehavior::class,
//           'createdAtAttribute' => 'created_at',
//           'updatedAtAttribute' => 'updated_at',
//           'value' => new Expression('NOW()'),
//        ];
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'payment_status', 'paymentOption', 'currency', 'rate', 'actual_amount', 'transaction_id', 'created_at', 'updated_at', 'issuedBy'], 'default', 'value' => null],
            [['bookingId'], 'required'],
            [['bookingId', 'issuedBy'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['amount', 'transaction_id'], 'string', 'max' => 255],
            [['payment_status'], 'string', 'max' => 191],
            [['paymentOption', 'currency', 'rate', 'actual_amount'], 'string', 'max' => 119],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bookingId' => 'Booking ID',
            'amount' => 'Amount',
            'payment_status' => 'Payment Status',
            'paymentOption' => 'Payment Option',
            'currency' => 'Currency',
            'rate' => 'Rate',
            'actual_amount' => 'Actual Amount',
            'transaction_id' => 'Transaction ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'issuedBy' => 'Issued By',
        ];
    }

}
