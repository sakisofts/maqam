<?php

namespace app\components\payments;
use Yii;
use app\models\Transaction;
use yii\base\Component;
use yii\helpers\Json;
use yii\db\Expression;

/**
 * TransactionService handles transaction record management and reconciliation
 */
class TransactionService extends Component
{
    /**
     * Create a new transaction record
     *
     * @param array $data Transaction data
     * @return Transaction
     * @throws \Exception on error
     */
    public function createTransaction($data)
    {
        $transaction = new Transaction();
        $transaction->attributes = $data;

        if (!$transaction->save()) {
            Yii::error('Failed to save transaction: ' . Json::encode($transaction->errors), __METHOD__);
            throw new \Exception('Failed to save transaction record: ' . Json::encode($transaction->errors));
        }

        return $transaction;
    }

    /**
     * Update transaction status
     *
     * @param string $transactionId Airtel Money transaction ID
     * @param string $status New status
     * @param string $paymentStatus Payment status from Airtel
     * @param string $message Status message
     * @param array $callbackData Optional callback data
     * @return Transaction|null
     */
    public function updateTransactionStatus($transactionId, $status, $paymentStatus = null, $message = null, $callbackData = null)
    {
        $transaction = Transaction::findOne(['transaction_id' => $transactionId]);

        if ($transaction) {
            $transaction->status = $status;

            if ($paymentStatus !== null) {
                $transaction->payment_status = $paymentStatus;
            }

            if ($message !== null) {
                $transaction->message = $message;
            }

            if ($callbackData !== null) {
                $transaction->callback_data = is_array($callbackData) ? Json::encode($callbackData) : $callbackData;
            }

            $transaction->updated_at = new Expression('NOW()');

            if (!$transaction->save()) {
                Yii::error('Failed to update transaction status: ' . Json::encode($transaction->errors), __METHOD__);
            }
        } else {
            Yii::error('Transaction not found for ID: ' . $transactionId, __METHOD__);
        }

        return $transaction;
    }

    /**
     * Get transaction by Airtel Money transaction ID
     *
     * @param string $transactionId
     * @return Transaction|null
     */
    public function getTransaction($transactionId)
    {
        return Transaction::findOne(['transaction_id' => $transactionId]);
    }

    /**
     * Get transactions by reference
     *
     * @param string $reference
     * @return Transaction[]
     */
    public function getTransactionsByReference($reference)
    {
        return Transaction::findAll(['reference' => $reference]);
    }

    /**
     * Get transaction stats for dashboard
     *
     * @param string $period 'today', 'week', 'month'
     * @return array
     */
    public function getTransactionStats($period = 'today')
    {
        $query = Transaction::find();

        // Add date condition based on period
        switch ($period) {
            case 'today':
                $query->andWhere('DATE(created_at) = CURDATE()');
                break;
            case 'week':
                $query->andWhere('created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)');
                break;
            case 'month':
                $query->andWhere('created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)');
                break;
        }

        // Get total amounts by status
        $stats = [
            'total_transactions' => $query->count(),
            'successful_amount' => $query->andWhere(['status' => Transaction::STATUS_SUCCESSFUL])->sum('amount'),
            'pending_amount' => $query->andWhere(['status' => Transaction::STATUS_PENDING])->sum('amount'),
            'failed_amount' => $query->andWhere(['status' => Transaction::STATUS_FAILED])->sum('amount'),
            'successful_count' => $query->andWhere(['status' => Transaction::STATUS_SUCCESSFUL])->count(),
            'pending_count' => $query->andWhere(['status' => Transaction::STATUS_PENDING])->count(),
            'failed_count' => $query->andWhere(['status' => Transaction::STATUS_FAILED])->count(),
        ];

        return $stats;
    }

    /**
     * Run reconciliation for pending transactions
     *
     * @param int $olderThanMinutes Check transactions older than this many minutes
     * @return array Results of reconciliation
     */
    public function reconcilePendingTransactions($olderThanMinutes = 30)
    {
        $results = [
            'processed' => 0,
            'updated' => 0,
            'errors' => 0,
        ];

        // Get pending transactions older than specified minutes
        $pendingTransactions = Transaction::find()
            ->where(['status' => Transaction::STATUS_PENDING])
            ->andWhere(['<', 'created_at', new Expression('DATE_SUB(NOW(), INTERVAL ' . $olderThanMinutes . ' MINUTE)')])
            ->limit(50)
            ->all();

        $results['processed'] = count($pendingTransactions);

        // Process each transaction
        foreach ($pendingTransactions as $transaction) {
            try {
                // Check status from Airtel Money API
                if ($transaction->type == Transaction::TYPE_COLLECTION) {
                    $response = Yii::$app->airtelMoney->checkCollectionStatus($transaction->transaction_id);
                } else {
                    $response = Yii::$app->airtelMoney->checkDisbursementStatus($transaction->transaction_id);
                }

                // Update transaction based on response
                if (!empty($response['status'])) {
                    $status = strtolower($response['status']);

                    switch ($status) {
                        case 'successful':
                        case 'success':
                            $newStatus = Transaction::STATUS_SUCCESSFUL;
                            break;
                        case 'failed':
                        case 'failure':
                            $newStatus = Transaction::STATUS_FAILED;
                            break;
                        case 'pending':
                            $newStatus = Transaction::STATUS_PENDING;
                            break;
                        default:
                            $newStatus = $transaction->status;
                    }

                    if ($newStatus != $transaction->status) {
                        $this->updateTransactionStatus(
                            $transaction->transaction_id,
                            $newStatus,
                            $status,
                            $response['message'] ?? null,
                            $response
                        );
                        $results['updated']++;
                    }
                }
            } catch (\Exception $e) {
                Yii::error('Reconciliation error for transaction ' . $transaction->transaction_id . ': ' . $e->getMessage(), __METHOD__);
                $results['errors']++;
            }
        }

        return $results;
    }
}
