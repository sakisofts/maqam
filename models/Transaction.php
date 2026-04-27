<?php
namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string $transaction_id
 * @property string $reference
 * @property string $phone
 * @property float $amount
 * @property string $currency
 * @property string $description
 * @property string $type
 * @property string $status
 * @property string $payment_status
 * @property string $message
 * @property string $callback_data
 * @property string $created_at
 * @property string $updated_at
 */
class Transaction extends ActiveRecord
{
    const TYPE_COLLECTION = 'collection';
    const TYPE_DISBURSEMENT = 'disbursement';
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESSFUL = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaction_id', 'reference', 'phone', 'amount', 'currency', 'type'], 'required'],
            [['amount'], 'number'],
            [['callback_data'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['transaction_id', 'reference'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['currency'], 'string', 'max' => 3],
            [['description'], 'string', 'max' => 255],
            [['type'], 'in', 'range' => [self::TYPE_COLLECTION, self::TYPE_DISBURSEMENT]],
            [['status'], 'in', 'range' => [self::STATUS_PENDING, self::STATUS_SUCCESSFUL, self::STATUS_FAILED, self::STATUS_CANCELLED]],
            [['payment_status', 'message'], 'string', 'max' => 255],
            [['transaction_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'reference' => 'Reference',
            'phone' => 'Phone',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'description' => 'Description',
            'type' => 'Type',
            'status' => 'Status',
            'payment_status' => 'Payment Status',
            'message' => 'Message',
            'callback_data' => 'Callback Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Get status label
     *
     * @return string
     */
    public function getStatusLabel()
    {
        $statusLabels = [
            self::STATUS_PENDING => '<span class="label label-warning">Pending</span>',
            self::STATUS_SUCCESSFUL => '<span class="label label-success">Successful</span>',
            self::STATUS_FAILED => '<span class="label label-danger">Failed</span>',
            self::STATUS_CANCELLED => '<span class="label label-default">Cancelled</span>',
        ];

        return $statusLabels[$this->status] ?? '<span class="label label-info">Unknown</span>';
    }

    /**
     * Get type label
     *
     * @return string
     */
    public function getTypeLabel()
    {
        $typeLabels = [
            self::TYPE_COLLECTION => '<span class="label label-primary">Collection</span>',
            self::TYPE_DISBURSEMENT => '<span class="label label-info">Disbursement</span>',
        ];

        return $typeLabels[$this->type] ?? '<span class="label label-default">Unknown</span>';
    }
}
