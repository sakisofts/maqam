<?php

namespace app\controllers;

use app\components\Generics\CrossHelper;
use app\components\Generics\ExcelPdfGenerator;
use app\components\Generics\ExportHelper;
use app\models\BookingPayments;
use app\models\Bookings;
use app\models\OneTimeServices;
use app\models\Payment;
use app\models\Reservation;
use Yii;

class ExportController extends BaseController
{
    public function actionPdfExport()
    {
        $modelName = Yii::$app->request->get('model');
        if (!empty($modelName)) {
            $modelClass = $modelName;
            if (class_exists($modelClass)) {
                $model = new $modelClass();
                ExcelPdfGenerator::generatePdf($model, CrossHelper::modelNameResolver($model));
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionExcelExport()
    {
        $modelName = Yii::$app->request->get('model');
        if (!empty($modelName)) {
            $modelClass = $modelName;
            if (class_exists($modelClass)) {
                $model = new $modelClass();
                ExportHelper::exportExcel($model);
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionReceipt($id = null, $t = null)
    {
        $bp = BookingPayments::findOne($id);
        $receiptData = [];
        $type = null;
        if ($bp) {
            if(!$this->bookingReceipt($bp)){
                return $this->redirect(Yii::$app->request->referrer);
            }
            $receiptData = $this->bookingReceipt($bp);
            $type = 'Booking ';
        }
        if (!$bp && $type == null) {
            $receiptData = $this->defaultDamy();
        }
        if ($t == 'prf') {
            if(!$this->paymentProof($id)){
                return $this->redirect(Yii::$app->request->referrer);
            }
            list($type, $receiptData) = $this->paymentProof($id);
        }
        if ($t == 'ots') {
            if(!$this->oneTimeReceipt($id)){
                return $this->redirect(Yii::$app->request->referrer);
            }
            list($type, $receiptData) = $this->oneTimeReceipt($id);
        }
        return $this->render('receipt', [
            'receiptData' => $receiptData,
            'address' => $this->addressInfo(),
            'type' => $type,
        ]);

    }

    /**
     * @param BookingPayments $bp
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function bookingReceipt(BookingPayments $bp): array
    {
        $bk = Bookings::findOne($bp->bookingId);
        return [
            ['label' => 'Received from', 'value' => $bk->name],
            ['label' => 'Date', 'value' => $bp->created_at ?? date('Y-m-d')],
            ['label' => 'Reference', 'value' => $bp->transaction_id ?? 'TRX-' . uniqid()],
            ['label' => 'Booking', 'value' => Yii::$app->formatter->asCurrency($bp->amount, 'USD')],
            ['label' => 'Mode of Payment', 'value' => $bp->paymentOption],
            ['label' => 'Paid Amount (USD)', 'value' => Yii::$app->formatter->asCurrency($bp->amount, 'USD')],
            ['label' => 'Amount Paid (UGX)', 'value' => Yii::$app->formatter->asCurrency($bp->actual_amount, 'UGX')],
            ['label' => 'Issued By', 'value' => ucfirst(CrossHelper::username($bp->issuedBy))],
        ];
    }

    /**
     * @return array[]
     */
    public function defaultDamy(): array
    {
        return [
            ['label' => 'Received from', 'value' => 'Kalanzi Ibrahim'],
            ['label' => 'Date', 'value' => '26/04/2025'],
            ['label' => 'Reference', 'value' => 'SM/UO/1'],
            ['label' => 'Sonda Mpola Target', 'value' => 'otherMonths_8400000'],
            ['label' => 'Mode of Payment', 'value' => 'AIRTEL Merchant'],
            ['label' => 'Amount Deposited', 'value' => '50,000'],
            ['label' => 'Amount Deposited Uptodate', 'value' => '7,732,000'],
            ['label' => 'Balance', 'value' => '668,000'],
            ['label' => 'Issued By', 'value' => 'RUTANANNA ARNOLD'],
        ];

    }

    /**
     * @param mixed $id
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function paymentProof(mixed $id): array
    {
        $py = Payment::findOne($id);
        $res = Reservation::findOne($py->reservation_id);
        $type = 'Payment Proof';
        $receiptData = [
            ['label' => 'Received from', 'value' => ucfirst(CrossHelper::username($res->user_id))],
            ['label' => 'Payment Date', 'value' => date('Y-m-d', strtotime($py->created_at)) ?? date('Y-m-d')],
            ['label' => 'Reference', 'value' => $py->payment_number ?? 'TRX-' . uniqid()],
            ['label' => 'Total Amount', 'value' => Yii::$app->formatter->asCurrency($res->total_amount, 'USD')],
            ['label' => 'Total Paid', 'value' => Yii::$app->formatter->asCurrency($res->amount_paid, 'USD')],
            ['label' => 'Paid', 'value' => Yii::$app->formatter->asCurrency($py->amount, 'USD')],
            ['label' => 'Rate', 'value' => $py->rate],
            ['label' => 'Exchange Rate', 'value' => $py->conversional_rate],
            ['label' => 'Balance Due', 'value' => Yii::$app->formatter->asCurrency($res->balance_due, 'USD')],
            ['label' => 'Served By', 'value' => ucfirst(CrossHelper::username(Yii::$app->user->id))],
        ];
        return array($type, $receiptData);
    }

    /**
     * @return string[]
     */
    public function addressInfo(): array
    {
        $address = [
            'floor' => '1st floor, AAA Complex',
            'road' => 'Bukoto Kisasi Road',
            'poBox' => 'P.O. Box 101776, Kampala, Uganda',
            'phone' => '+256709741486',
            'email' => 'info@maqamtravels.com',
        ];
        return $address;
    }

    /**
     * @param mixed $id
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function oneTimeReceipt(mixed $id): array
    {
        $ot = OneTimeServices::findOne($id);
        $p = Payment::findOne(['reservation_id' => $id, 'transaction_id' => 'ots']);
        if(!isset($p)){
            Yii::$app->session->setFlash('error', 'Payment not found');
            return [];
        }
        $serv = '';
        foreach ($ot->services as $s) {
            $serv .= '<span class="badge badge-pill  bg-primary mx-1">' . CrossHelper::camelCaseToSpaces($s) . '</span>';
        }
        $type = 'One Time Service';
        $receiptData = [
            ['label' => 'Received from', 'value' => CrossHelper::username($ot->client_id)],
            ['label' => 'Date', 'value' => $ot->created_at ?? date('Y-m-d')],
            ['label' => 'Reference', 'value' => $p->payment_number ?? 'TRX-' . uniqid()],
            ['label' => 'Service(s)', 'value' => $serv],
            ['label' => 'Mode of Payment', 'value' => $p->payment_method],
            ['label' => 'Paid Amount', 'value' => Yii::$app->formatter->asCurrency($p->amount, 'USD')],
            ['label' => 'Rate', 'value' => $p->rate],
            ['label' => 'Exchange Rate', 'value' => $p->conversional_rate],
            ['label' => 'Served By', 'value' => ucfirst(CrossHelper::username($ot->created_by))],
        ];
        return array($type, $receiptData);
    }


}
