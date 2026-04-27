<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use app\models\PaymentForm;
use app\models\Transaction;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

/**
 * PaymentController handles Airtel Money payment operations
 */
class PaymentsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'pay', 'collect', 'disburse', 'check-status', 'status', 'transactions'],
                        'allow' => true,
                        'roles' => ['@'], // Authenticated users only
                    ],
                    [
                        'actions' => ['callback'],
                        'allow' => true, // Callback can be accessed without authentication
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'collect' => ['post'],
                    'disburse' => ['post'],
                    'check-status' => ['get'],
                    'callback' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Display payment form
     *
     * @return string
     */
    public function actionPay($ref=null)
    {
        $model = new PaymentForm();
        if ($ref){
            $model->reference = $ref;
            $model->amount=0;
            $model->description = 'Payment for test';
        }

//        $airtel = Yii::$app->airtelApi;
//        $reference = uniqid('ORD_');
//        $msisdn = '256756913885';
//        $amount = 5000;
//        $description = 'Payment for booking Order ';
//
//        $response = $airtel->requestPayment($reference, $msisdn, $amount, $description);
//
//        var_dump($response);

//
//        if (isset($response['status']) && $response['status']['code'] === '200') {
//            echo "Payment request sent. Awaiting customer confirmation.";
//        } else {
//            echo "Payment request failed: " . json_encode($response);
//        }


//        return ;


        return $this->render('pay', [
            'model' => $model,
        ]);
    }

    /**
     * Show transactions list
     *
     * @return string
     */
    public function actionTransactions()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Transaction::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('transactions', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Show transaction status page
     *
     * @param string $id Transaction ID
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionStatus($id)
    {
        $transaction = Yii::$app->transactionService->getTransaction($id);

        if (!$transaction) {
            throw new NotFoundHttpException('Transaction not found.');
        }

        return $this->render('status', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * Initiates a collection from customer
     *
     * @return Response
     */
    public function actionCollect()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $phone ='';
        $amount = '';
        $reference = '';
        $description = '';

//        $payload = [
//            'reference' => 'ORDER123456',
//            'subscriber' => [
//                'country' => 'UGX',
//                'msisdn' => '256756913885',
//            ],
//            'transaction' => [
//                'amount' => 1000,
//                'id' => uniqid('txn_'),
//            ],
//        ];
//
//        ;


        try {
            $request = Yii::$app->request->post();

            // Check if data comes from a form with PaymentForm structure
            if (isset($request['PaymentForm'])) {
                $paymentData = $request['PaymentForm'];
                $phone = $paymentData['phone'] ?? null;
                $amount = isset($paymentData['amount']) ? (float)$paymentData['amount'] : null;
                $reference = $paymentData['reference'] ?? null;
                $description = $paymentData['description'] ?? 'Payment collection';
            } else {
                // Direct access to parameters (original way)
                $phone = $request['phone'] ?? null;
                $amount = isset($request['amount']) ? (float)$request['amount'] : null;
                $reference = $request['reference'] ?? null;
                $description = $request['description'] ?? 'Payment collection';
            }

            // Validate required parameters
            if (empty($phone) || empty($amount) || empty($reference)) {
                throw new BadRequestHttpException('Phone, amount and reference are required');
            }

            // Process the collection
            $result = $result = Yii::$app->airtelApi->requestPayment($reference, $phone, $amount, $description);

            // Log the transaction
            $transactionData = [
                'transaction_id' => $result['transaction']['id'],
                'reference' => $reference,
                'phone' => $phone,
                'amount' => $amount,
                'currency' => Yii::$app->airtelMoney->currencyCode,
                'description' => $description,
                'type' => Transaction::TYPE_COLLECTION,
                'status' => Transaction::STATUS_PENDING,
                'payment_status' => $result['status'] ?? 'pending',
                'message' => $result['message'] ?? null,
            ];

            $transaction = Yii::$app->transactionService->createTransaction($transactionData);

            return [
                'success' => true,
                'message' => 'Collection initiated successfully',
                'data' => $result
            ];

        } catch (\Exception $e) {
            Yii::error('Collection error: ' . $e->getMessage(), __METHOD__);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Initiates a disbursement to customer
     *
     * @return Response
     */
    public function actionDisburse()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $request = Yii::$app->request->getBodyParams();

            // Validate required parameters
            if (empty($request['phone']) || empty($request['amount']) || empty($request['reference'])) {
                throw new BadRequestHttpException('Phone, amount and reference are required');
            }

            $phone = $request['phone'];
            $amount = (float)$request['amount'];
            $reference = $request['reference'];
            $description = $request['description'] ?? 'Disbursement';

            // Process the disbursement
            $result = Yii::$app->airtelMoney->processDisbursement(
                $phone,
                $amount,
                $reference,
                $description
            );

            // Log the transaction
            $transactionData = [
                'transaction_id' => $result['transaction']['id'],
                'reference' => $reference,
                'phone' => $phone,
                'amount' => $amount,
                'currency' => Yii::$app->airtelMoney->currencyCode,
                'description' => $description,
                'type' => Transaction::TYPE_DISBURSEMENT,
                'status' => Transaction::STATUS_PENDING,
                'payment_status' => $result['status'] ?? 'pending',
                'message' => $result['message'] ?? null,
            ];

            $transaction = Yii::$app->transactionService->createTransaction($transactionData);

            return [
                'success' => true,
                'message' => 'Disbursement initiated successfully',
                'data' => $result
            ];

        } catch (\Exception $e) {
            Yii::error('Disbursement error: ' . $e->getMessage(), __METHOD__);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Check transaction status
     *
     * @param string $id Transaction ID
     * @param string $type Transaction type
     * @return Response
     */
    public function actionCheckStatus($id, $type = 'collection')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            // Check transaction status based on type
            if ($type === 'collection') {
                $result = Yii::$app->airtelMoney->checkCollectionStatus($id);
            } else if ($type === 'disbursement') {
                $result = Yii::$app->airtelMoney->checkDisbursementStatus($id);
            } else {
                throw new BadRequestHttpException('Invalid transaction type');
            }

            // Update transaction record
            $status = strtolower($result['status'] ?? '');

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
                    $newStatus = null;
            }

            if ($newStatus) {
                Yii::$app->transactionService->updateTransactionStatus(
                    $id,
                    $newStatus,
                    $status,
                    $result['message'] ?? null,
                    $result
                );
            }

            return [
                'success' => true,
                'data' => $result
            ];

        } catch (\Exception $e) {
            Yii::error('Status check error: ' . $e->getMessage(), __METHOD__);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Handles callbacks from Airtel Money
     *
     * @return Response
     */
    public function actionCallback()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            // Get the raw post data
            $rawData = Yii::$app->request->getRawBody();
            Yii::info('Callback raw data: ' . $rawData, __METHOD__);

            $request = Json::decode($rawData);
            $callbackType = Yii::$app->request->get('type', 'collection');

            // Get transaction ID from the callback data
            $transactionId = $request['transaction']['id'] ?? null;
            if (!$transactionId) {
                throw new BadRequestHttpException('Transaction ID not found in callback data');
            }

            // Process based on callback type
            if ($callbackType === 'collection') {
                $result = Yii::$app->airtelMoney->handleCollectionCallback($request);
            } else if ($callbackType === 'disbursement') {
                $result = Yii::$app->airtelMoney->handleDisbursementCallback($request);
            } else {
                throw new BadRequestHttpException('Invalid callback type');
            }

            // Update transaction status
            $status = strtolower($request['transaction']['status'] ?? '');

            switch ($status) {
                case 'successful':
                case 'success':
                    $newStatus = Transaction::STATUS_SUCCESSFUL;
                    break;
                case 'failed':
                case 'failure':
                    $newStatus = Transaction::STATUS_FAILED;
                    break;
                default:
                    $newStatus = Transaction::STATUS_PENDING;
            }

            Yii::$app->transactionService->updateTransactionStatus(
                $transactionId,
                $newStatus,
                $status,
                $request['transaction']['message'] ?? null,
                $request
            );

            return [
                'success' => true
            ];

        } catch (\Exception $e) {
            Yii::error('Callback processing error: ' . $e->getMessage(), __METHOD__);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
