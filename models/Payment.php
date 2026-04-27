<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property string $payment_number
 * @property int $reservation_id
 * @property float $amount
 * @property string $payment_date
 * @property string $payment_method
 * @property string|null $transaction_id
 * @property string $payment_status
 * @property string $payment_type
 * @property string|null $from_currency
 * @property string|null $to_currency
 * @property string|null $conversional_rate
 * @property string|null $rate
 * @property string|null $notes
 * @property string|null $receipt_number
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 */
class Payment extends \yii\db\ActiveRecord
{

    public $payable;

    /**
     * ENUM field values
     */
    const PAYMENT_METHOD_CASH = 'Cash';
    const PAYMENT_METHOD_CREDIT_CARD = 'Credit Card';
    const PAYMENT_METHOD_BANK_TRANSFER = 'Bank Transfer';
    const PAYMENT_METHOD_PAYPAL = 'PayPal';
    const PAYMENT_METHOD_OTHER = 'Other';
    const PAYMENT_STATUS_PENDING = 'Pending';
    const PAYMENT_STATUS_COMPLETED = 'Completed';
    const PAYMENT_STATUS_FAILED = 'Failed';
    const PAYMENT_STATUS_REFUNDED = 'Refunded';
    const PAYMENT_TYPE_DEPOSIT = 'Deposit';
    const PAYMENT_TYPE_INSTALLMENT = 'Installment';
    const PAYMENT_TYPE_FULL_PAYMENT = 'Full Payment';
    const PAYMENT_TYPE_ADDITIONAL_SERVICE = 'Additional Service';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaction_id', 'notes', 'receipt_number'], 'default', 'value' => null],
            [['payment_status'], 'default', 'value' => 'Pending'],
            [['payment_number', 'reservation_id', 'amount', 'payment_date', 'payment_method', 'payment_type', 'created_at', 'updated_at'], 'required'],
            [['reservation_id','created_by', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
            [['payment_date'], 'safe'],
            [['payment_method', 'payment_status','rate','conversional_rate','to_currency','from_currency', 'payment_type', 'notes'], 'string'],
            [['payment_number', 'receipt_number'], 'string', 'max' => 50],
            [['transaction_id'], 'string', 'max' => 255],
            ['payment_method', 'in', 'range' => array_keys(self::optsPaymentMethod())],
            ['payment_status', 'in', 'range' => array_keys(self::optsPaymentStatus())],
            ['payment_type', 'in', 'range' => array_keys(self::optsPaymentType())],
            [['payment_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment_number' => 'Payment Number',
            'reservation_id' => 'Reservation ID',
            'from_currency' => 'From Currency',
            'to_currency' => 'To Currency',
            'rate' => 'Rate',
            'conversional_rate' => 'conversion',
            'amount' => 'Amount',
            'payment_date' => 'Payment Date',
            'payment_method' => 'Payment Method',
            'transaction_id' => 'Transaction ID',
            'payment_status' => 'Payment Status',
            'payment_type' => 'Payment Type',
            'notes' => 'Notes',
            'receipt_number' => 'Receipt Number',
            'created_at' => 'Created At',
            'created_by' => 'Created by',
            'updated_at' => 'Updated At',
        ];
    }


    /**
     * column payment_method ENUM value labels
     * @return string[]
     */
    public static function optsPaymentMethod()
    {
        return [
            self::PAYMENT_METHOD_CASH => 'Cash',
            self::PAYMENT_METHOD_CREDIT_CARD => 'Credit Card',
            self::PAYMENT_METHOD_BANK_TRANSFER => 'Bank Transfer',
            self::PAYMENT_METHOD_PAYPAL => 'PayPal',
            self::PAYMENT_METHOD_OTHER => 'Other',
        ];
    }

    /**
     * column payment_status ENUM value labels
     * @return string[]
     */
    public static function optsPaymentStatus()
    {
        return [
            self::PAYMENT_STATUS_PENDING => 'Pending',
            self::PAYMENT_STATUS_COMPLETED => 'Completed',
            self::PAYMENT_STATUS_FAILED => 'Failed',
            self::PAYMENT_STATUS_REFUNDED => 'Refunded',
        ];
    }

    /**
     * column payment_type ENUM value labels
     * @return string[]
     */
    public static function optsPaymentType()
    {
        return [
            self::PAYMENT_TYPE_DEPOSIT => 'Deposit',
            self::PAYMENT_TYPE_INSTALLMENT => 'Installment',
            self::PAYMENT_TYPE_FULL_PAYMENT => 'Full Payment',
            self::PAYMENT_TYPE_ADDITIONAL_SERVICE => 'Additional Service',
        ];
    }

    /**
     * @return string
     */
    public function displayPaymentMethod()
    {
        return self::optsPaymentMethod()[$this->payment_method];
    }

    /**
     * @return bool
     */
    public function isPaymentMethodCash()
    {
        return $this->payment_method === self::PAYMENT_METHOD_CASH;
    }

    public function setPaymentMethodToCash()
    {
        $this->payment_method = self::PAYMENT_METHOD_CASH;
    }

    /**
     * @return bool
     */
    public function isPaymentMethodCreditCard()
    {
        return $this->payment_method === self::PAYMENT_METHOD_CREDIT_CARD;
    }

    public function setPaymentMethodToCreditCard()
    {
        $this->payment_method = self::PAYMENT_METHOD_CREDIT_CARD;
    }

    /**
     * @return bool
     */
    public function isPaymentMethodBankTransfer()
    {
        return $this->payment_method === self::PAYMENT_METHOD_BANK_TRANSFER;
    }

    public function setPaymentMethodToBankTransfer()
    {
        $this->payment_method = self::PAYMENT_METHOD_BANK_TRANSFER;
    }

    /**
     * @return bool
     */
    public function isPaymentMethodPaypal()
    {
        return $this->payment_method === self::PAYMENT_METHOD_PAYPAL;
    }

    public function setPaymentMethodToPaypal()
    {
        $this->payment_method = self::PAYMENT_METHOD_PAYPAL;
    }

    /**
     * @return bool
     */
    public function isPaymentMethodOther()
    {
        return $this->payment_method === self::PAYMENT_METHOD_OTHER;
    }

    public function setPaymentMethodToOther()
    {
        $this->payment_method = self::PAYMENT_METHOD_OTHER;
    }

    /**
     * @return string
     */
    public function displayPaymentStatus()
    {
        return self::optsPaymentStatus()[$this->payment_status];
    }

    /**
     * @return bool
     */
    public function isPaymentStatusPending()
    {
        return $this->payment_status === self::PAYMENT_STATUS_PENDING;
    }

    public function setPaymentStatusToPending()
    {
        $this->payment_status = self::PAYMENT_STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isPaymentStatusCompleted()
    {
        return $this->payment_status === self::PAYMENT_STATUS_COMPLETED;
    }

    public function setPaymentStatusToCompleted()
    {
        $this->payment_status = self::PAYMENT_STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isPaymentStatusFailed()
    {
        return $this->payment_status === self::PAYMENT_STATUS_FAILED;
    }

    public function setPaymentStatusToFailed()
    {
        $this->payment_status = self::PAYMENT_STATUS_FAILED;
    }

    /**
     * @return bool
     */
    public function isPaymentStatusRefunded()
    {
        return $this->payment_status === self::PAYMENT_STATUS_REFUNDED;
    }

    public function setPaymentStatusToRefunded()
    {
        $this->payment_status = self::PAYMENT_STATUS_REFUNDED;
    }

    /**
     * @return string
     */
    public function displayPaymentType()
    {
        return self::optsPaymentType()[$this->payment_type];
    }

    /**
     * @return bool
     */
    public function isPaymentTypeDeposit()
    {
        return $this->payment_type === self::PAYMENT_TYPE_DEPOSIT;
    }

    public function setPaymentTypeToDeposit()
    {
        $this->payment_type = self::PAYMENT_TYPE_DEPOSIT;
    }

    /**
     * @return bool
     */
    public function isPaymentTypeInstallment()
    {
        return $this->payment_type === self::PAYMENT_TYPE_INSTALLMENT;
    }

    public function setPaymentTypeToInstallment()
    {
        $this->payment_type = self::PAYMENT_TYPE_INSTALLMENT;
    }

    /**
     * @return bool
     */
    public function isPaymentTypeFullPayment()
    {
        return $this->payment_type === self::PAYMENT_TYPE_FULL_PAYMENT;
    }

    public function setPaymentTypeToFullPayment()
    {
        $this->payment_type = self::PAYMENT_TYPE_FULL_PAYMENT;
    }

    /**
     * @return bool
     */
    public function isPaymentTypeAdditionalService()
    {
        return $this->payment_type === self::PAYMENT_TYPE_ADDITIONAL_SERVICE;
    }

    public function setPaymentTypeToAdditionalService()
    {
        $this->payment_type = self::PAYMENT_TYPE_ADDITIONAL_SERVICE;
    }

    public function beforeSave($insert)
    {
        $this->receipt_number = self::generateReference('No');
        return parent::beforeSave($insert);
    }

    public static function generateReference($px=null)
    {
        $year = date('Y');
        $prefix = $px.'-' . $year . '-';
        // Find the highest existing number
        $latestStaff = Payment::find()
            ->where(['LIKE', 'payment_number', $prefix . '%', false])
            ->orderBy(['id' => SORT_DESC])
            ->one();
        if ($latestStaff) {
            $lastNumber = (int)substr($latestStaff->payment_number, strlen($prefix));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }


}
