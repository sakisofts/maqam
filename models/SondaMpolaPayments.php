<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sonda_mpola_payments".
 *
 * @property int $id
 * @property int|null $sondaMpolaId
 * @property string|null $amount
 * @property string|null $payment_option
 * @property string|null $payment_status
 * @property string|null $currency
 * @property string|null $rate
 * @property string|null $actual_amount
 * @property string|null $balance
 * @property string|null $target_amount_status
 * @property int|null $receipted_by
 * @property int|null $issuedBy
 * @property string|null $transaction_id
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class SondaMpolaPayments extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sonda_mpola_payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sondaMpolaId', 'amount', 'payment_option', 'payment_status', 'currency', 'rate', 'actual_amount', 'balance', 'target_amount_status', 'receipted_by', 'issuedBy', 'transaction_id'], 'default', 'value' => null],
            [['sondaMpolaId', 'receipted_by', 'issuedBy'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['amount', 'payment_option', 'payment_status', 'currency', 'rate', 'actual_amount', 'balance', 'target_amount_status', 'transaction_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sondaMpolaId' => 'Sonda Mpola ID',
            'amount' => 'Amount',
            'payment_option' => 'Payment Option',
            'payment_status' => 'Payment Status',
            'currency' => 'Currency',
            'rate' => 'Rate',
            'actual_amount' => 'Actual Amount',
            'balance' => 'Balance',
            'target_amount_status' => 'Target Amount Status',
            'receipted_by' => 'Receipted By',
            'issuedBy' => 'Issued By',
            'transaction_id' => 'Transaction ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
