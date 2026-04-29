<?php

namespace app\controllers;

use app\models\BookingPayments;
use app\models\SondaMpolaPayments;
use app\models\SondaMpolas;
use app\models\Transaction;
use Yii;
use yii\rest\Controller;

class ApiController extends Controller
{
    public function actionPay()
    {
        $request = \Yii::$app->request;
        if (!$request->isPost) {
            return [
                'status' => 'error',
                'message' => 'Method not allowed'
            ];
        }

        $data = json_decode($request->getRawBody(), true);
        $reference = $data['reference'] ?? null;
        $msisdn = $data['msisdn'] ?? null;
        $amount = $data['amount'] ?? 0;
        $description = $data['description'] ?? null;

        if (!$reference || !$msisdn) {
            return [
                'status' => 'error',
                'message' => 'Missing required parameters'
            ];
        }


        try {
            $airtelApi = \Yii::$app->airtelApi;
            $response = $airtelApi->pay(
                $reference,
                $msisdn,
                $amount,
                $description
            );

            $bookings = $data['booking'];
            $deposited = $data['sonda_mpola'];
            $type = $data['type'];

//            {
//                "data": {
//                "transaction": {
//                    "airtel_money_id": "product-partner-**41",
//            "id": "AB***141",
//            "reference_id": "18****354",
//            "status": "TS"
//        }
//    },
//    "status": {
//                "code": "200",
//        "message": "Success",
//        "response_code": "DP00900001001",
//        "result_code": "ESB000010",
//        "success": true
//    }
//}
            echo \Safe\json_encode($response);

            if ($response['success'] && isset($response['data']['data']['transaction']) && isset($response['data']['status'])) {
                // Log the transaction
                $transaction = $response['data']['data']['transaction'];
                $transactionId = $transaction['id'];
                $transactionStatus = $transaction['status'];
                $states = $response['data']['status'];
                $this->logTransaction($transactionId, $reference, $msisdn, $amount, $states['message'], $description, $transactionStatus,true);
                $this->updateExternalTables($type, $bookings, $amount, $transaction, $deposited);
                return [
                    'status' => 'success',
                    'data' => $response['data']
                ];

            }
            return [
                'status' => 'error',
                'message' => $response,
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

public function actionRequestPayment()
    {
        $request = \Yii::$app->request;
        if (!$request->isPost) {
            return [
                'status' => 'error',
                'message' => 'Method not allowed'
            ];
        }

        $data = json_decode($request->getRawBody(), true);
        $reference = $data['reference'] ?? null;
        $msisdn = $data['msisdn'] ?? null;
        $amount = $data['amount'] ?? 0;
        $description = $data['description'] ?? null;

        if (!$reference || !$msisdn || !$amount) {
            return [
                'status' => 'error',
                'message' => 'Missing required parameters'
            ];
        }


        try {
            $airtelApi = \Yii::$app->airtelApi;
            $response = $airtelApi->requestPayment(
                $reference,
                $msisdn,
                $amount,
                $description
            );

            $bookings = $data['booking'];
            $deposited = $data['sonda_mpola'];
            $type = $data['type'];

            if ($response['success'] && isset($response['data']['data']['transaction'])) {
                // Log the transaction
                $transaction = $response['data']['data']['transaction'];
                $transactionId = $transaction['id'];
                $transactionStatus = $transaction['status'];
                $states = $response['data']['status'];
                $this->logTransaction($transactionId, $reference, $msisdn, $amount, $states['message'], $description, $transactionStatus);
                $this->updateExternalTables($type, $bookings, $amount, $transaction, $deposited);
                return [
                    'status' => 'success',
                    'data' => $response['data']
                ];

            }
            return [
                'status' => 'error',
                'message' => $response,
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @return string[]
     * poll to this action to check the status of the payment
     */
    public function actionStatus(){
        $request = Yii::$app->request;
        $airtelApi = \Yii::$app->airtelApi;
        $data = json_decode($request->getRawBody(), true);
        $res = [
            'status' => 'error',
            'message' => 'Failed'
        ];
        if (!$request->isPost) {
            $res = $airtelApi->checkPaymentStatus($data['txn_id']);
        }
        return $res;
    }

    public function actionKyc(){
        $request = Yii::$app->request;
        $airtelApi = \Yii::$app->airtelApi;
        $data = json_decode($request->getRawBody(), true);
        if (!$request->isPost) {
            $res = $airtelApi->kyc($data['number']);
        }
        return $res;
    }

    public function actionAccount(){
        $airtelApi = \Yii::$app->airtelApi;
        return $airtelApi->account("0756913885");
    }

    /**
     * @param $transactionId
     * @param mixed $reference
     * @param mixed $msisdn
     * @param mixed $amount
     * @param $message
     * @param mixed $description
     * @param $transactionStatus
     * @return void
     */
    public function logTransaction($transactionId, mixed $reference, mixed $msisdn, mixed $amount, $message, mixed $description, $transactionStatus,$py=null): void
    {
        $transactionData = [
            'transaction_id' => $transactionId,
            'reference' => $reference,
            'phone' => $msisdn,
            'amount' => $amount,
            'currency' => 'UGX',
            'description' => $message ?? $description,
            'type' => !$py ? Transaction::TYPE_COLLECTION : Transaction::TYPE_DISBURSEMENT,
            'status' => $transactionStatus == 'Success.' ? Transaction::STATUS_SUCCESSFUL : Transaction::STATUS_PENDING,
            'payment_status' => 'pending',
            'message' => $message ?? null,
        ];
        Yii::$app->transactionService->createTransaction($transactionData);
    }

    /**
     * @param mixed $type
     * @param mixed $bookings
     * @param mixed $amount
     * @param $transaction
     * @param mixed $deposited
     * @return void
     * @throws \yii\db\Exception
     */
    public function updateExternalTables(mixed $type, mixed $bookings, mixed $amount, $transaction, mixed $deposited): void
    {
        if ($type === 'booking') {
            $bk = new BookingPayments();
            $bk->bookingId = $bookings['bookingId'];
            $bk->paymentOption = $bookings['paymentOption'];
            $bk->amount = $amount;
            $bk->currency = 'UGX';
            $bk->actual_amount = $amount;
            $bk->transaction_id = $transaction['id'];
            $bk->save(false);
        }
        if ($type === 'sonda_mpola') {
            $sond = new SondaMpolaPayments();
            $oc = SondaMpolaPayments::findOne(['id' => $deposited['sondaMpolaId']]);
            if ($oc->amount) {
                $sond->amount = $amount;
                $sond->currency = 'UGX';
                $sond->actual_amount = $amount;
                $sond->transaction_id = $transaction['id'];
                $sond->receipted_by = $deposited['authId'];
                $sond->payment_option = $deposited['paymentOption'];
                $sond->payment_status = $transaction['status'] ?? Transaction::STATUS_PENDING;
                $sond->save(false);
            }
        }
    }

    public function actionGetAccessToken()
    {
        if (Yii::$app->request->isGet) {
            return [
                'status' => 'error',
                'message' => 'Method not allowed'
            ];
        }

        try {
            $token = Yii::$app->airtelAuth->getToken();

            return [
                'status' => 'success',
                'token' => $token
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function actionAirtel()
    {


        $request = Yii::$app->request;
        if (!$request->isPost) {
            return [
                'status' => 'error',
                'message' => 'Method not allowed'
            ];
        }

        $payload = $request->getRawBody();
        $data = json_decode($payload, true);


        if (
            isset($data['transaction'])
        ) {
            $transactionId = $data['transaction']['id'] ?? null;

            if ($transactionId === null) {
                return $this->asJson(['message' => 'Missing transaction ID.']);
            }

            $payment = Transaction::findOne(['transaction_id' => $transactionId]);
            $booking = BookingPayments::findOne(['transaction_id' => $transactionId]);
            $sd = SondaMpolaPayments::findOne(['transaction_id' => $transactionId]);

//            trigger notifications
            if ($payment && $payment->status !== 'completed') {
                $payment->status = 'completed';
                $payment->payment_status = 'Settled';
                $payment->callback_data = json_encode($data);
                $payment->save(false);
            }

            if ($booking && $booking->payment_status !== 'completed') {
                $booking->payment_status = 'completed';
                $booking->save(false);
            }

            if ($sd && $sd->payment_status !== 'completed') {
                $sd->payment_status = 'completed';
                $sd->save(false);

                $bk = SondaMpolas::findOne(['id' => $sd->sondaMpolaId]);
                if ($bk) {
                    $bk->balance += $sd->amount;
                    $bk->save(false);
                }
            }

            return $this->asJson(['message' => 'Transaction processed successfully.']);
        }else{
            $t = new Transaction();
            $t->callback_data = json_encode($data);
            $t->transaction_id = uniqid('test_');
            $t->reference = 'testing';
            $t->phone = '0756913885';
            $t->amount = 5000;
            $t->currency = 'UGX';
            $t->description = 'Test capturing';
            $t->type = 'Just testing';
            $t->status = 'Success.';
            $t->payment_status = 'pending';
            $t->message = 'method used '.$request->method;
            $t->save(false);
        }

        // Fallback
        return $this->asJson(['message' => 'Transaction failed or invalid.'], 400);
    }


}
