<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class AirtelPaymentController extends  BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
     * Initiates a collection from customer
     *
     * @return Response
     */
    public function actionCollect()
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
            $description = $request['description'] ?? 'Payment collection';

            // Process the collection
            $result = Yii::$app->airtelMoney->processCollection(
                $phone,
                $amount,
                $reference,
                $description
            );

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
     * @return Response
     */
    public function actionCheckStatus($id, $type = 'collection')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        try {
            // Check transaction status based on type
            if ($type === 'collection') {
                $result = Yii::$app->airtelMoney->checkCollectionStatus($id);
            } elseif ($type === 'disbursement') {
                $result = Yii::$app->airtelMoney->checkDisbursementStatus($id);
            } else {
                throw new BadRequestHttpException('Invalid transaction type');
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
            $request = Yii::$app->request->getBodyParams();
            $callbackType = Yii::$app->request->get('type', 'collection');

            if ($callbackType === 'collection') {
                $result = Yii::$app->airtelMoney->handleCollectionCallback($request);
            } else if ($callbackType === 'disbursement') {
                $result = Yii::$app->airtelMoney->handleDisbursementCallback($request);
            } else {
                throw new BadRequestHttpException('Invalid callback type');
            }

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

    /**
     * Get account balance
     *
     * @return Response
     */
    public function actionBalance()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $result = Yii::$app->airtelMoney->getAccountBalance();

            return [
                'success' => true,
                'data' => $result
            ];

        } catch (\Exception $e) {
            Yii::error('Balance check error: ' . $e->getMessage(), __METHOD__);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }



}
