<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_plan_installment".
 *
 * @property int $id
 * @property int $payment_plan_id
 * @property int $installment_number
 * @property string $due_date
 * @property float $amount
 * @property string $status
 * @property int|null $payment_id
 * @property int $created_at
 * @property int $updated_at
 */
class PaymentPlanInstallment extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_PENDING = 'Pending';
    const STATUS_PAID = 'Paid';
    const STATUS_OVERDUE = 'Overdue';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_plan_installment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_id'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'Pending'],
            [['payment_plan_id', 'installment_number', 'due_date', 'amount', 'created_at', 'updated_at'], 'required'],
            [['payment_plan_id', 'installment_number', 'payment_id', 'created_at', 'updated_at'], 'integer'],
            [['due_date'], 'safe'],
            [['amount'], 'number'],
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
            'payment_plan_id' => 'Payment Plan ID',
            'installment_number' => 'Installment Number',
            'due_date' => 'Due Date',
            'amount' => 'Amount',
            'status' => 'Status',
            'payment_id' => 'Payment ID',
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
            self::STATUS_PAID => 'Paid',
            self::STATUS_OVERDUE => 'Overdue',
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
    public function isStatusOverdue()
    {
        return $this->status === self::STATUS_OVERDUE;
    }

    public function setStatusToOverdue()
    {
        $this->status = self::STATUS_OVERDUE;
    }
}
