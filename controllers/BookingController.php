<?php

namespace app\controllers;

use app\components\Generics\CrossHelper;
use app\models\Amenities;
use app\models\AmenitiesSearch;
use app\models\BookingPayments;
use app\models\Bookings;
use app\models\BookingSearch;
use app\models\MasterPackage;
use app\models\OneTimeServices;
use app\models\OneTimeServiceSearch;
use app\models\Packages;
use app\models\Payment;
use app\models\PaymentSearch;
use app\models\Reservation;
use app\models\ReservationSearch;
use app\models\SondaMpolas;
use app\models\SondaMpolaSearch;
use app\models\User;
use Yii;
use yii\web\Controller;

class BookingController extends BaseController
{

    public function actionIndex()
    {
        $search = new BookingSearch();
        $dataProvider = $search->search(Yii::$app->request->post());
        $res = ['provider' => $dataProvider,
            'searchFields' => $search->searchFields(),
            'search' => $search,
            'export' => $search,
            'model' => $dataProvider->getModels()
        ];
        return $this->render('index', $res);
    }

    public function actionReserve()
    {
        $search = new ReservationSearch();
        $dataProvider = $search->search(Yii::$app->request->post());
        $res = ['provider' => $dataProvider,
            'searchFields' => $search->searchFields(),
            'search' => $search,
            'export' => $search,
            'model' => $dataProvider->getModels()
        ];
        return $this->render('reservations', $res);
    }

    public function actionReserveCreate($id = null)
    {
        $model = $id ? (new Reservation())::findOne($id) : new Reservation();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['reserve']);
        }
        return $this->render('reserve-create', [
            'model' => $model,
        ]);
    }

    public function actionOts()
    {
        $search = new OneTimeServiceSearch();
        $dataProvider = $search->search(Yii::$app->request->post());
        $res = ['provider' => $dataProvider,
            'searchFields' => $search->searchFields(),
            'search' => $search,
            'export' => $search,
            'model' => $dataProvider->getModels()
        ];
        return $this->render('ots', $res);
    }

    public function actionOtsCreate($id = null)
    {
        $model = $id ? (new OneTimeServices())::findOne($id) : new OneTimeServices();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['ots']);
        }
        return $this->render('ots-create', ['model' => $model]);
    }

    public function actionServicePrice()
    {
        $id = Yii::$app->request->post('id');
        return json_encode([
            'success' => true,
            'price' => Amenities::findOne(['amenity' => CrossHelper::camelCaseToSpaces($id)])->charges
        ]);
    }

    public function actionGetPrice()
    {
        $id = Yii::$app->request->Post('id');
        $d = MasterPackage::findOne($id);
        return json_encode(["success" => true, "price" => $d->reservation_fee]);
    }

    public function actionAmenities(): string
    {
        $search = new AmenitiesSearch();
        $dataProvider = $search->search(Yii::$app->request->post());
        $res = ['provider' => $dataProvider,
            'searchFields' => $search->searchFields(),
            'search' => $search,
            'export' => $search,
            'model' => $dataProvider->getModels()
        ];
        return $this->render('amenity', $res);
    }

    public function actionAmenity($id = null)
    {
        $model = $id ? Amenities::findOne($id) : new Amenities();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['amenities']);
        }
        return $this->render('amenities', ['model' => $model]);
    }

    public function actionPayNow($id = null, $type = null)
    {
        $model = new Payment();
        $model->created_by = Yii::$app->user->id;
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $model->reservation_id = $id;
            $this->oneTimeServices($type, $model, $id);
            $this->reservations($type, $model, $id);
            Yii::$app->session->setFlash('success', 'Payment successfully recorded.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->prefillAmount($type, $id, $model);
        return $this->render('payment', ['model' => $model,
            'title' => $type === 'ots' ? 'One Time Service' : 'Reservation',
            'payable'=>$model->payable,
            'type' => $type
        ]);
    }


    public function actionDropAmenity($id){
        $model = Amenities::findOne($id);
        if($model->delete()){
            Yii::$app->session->setFlash('success', 'Amenity successfully deleted.');
            return $this->redirect(Yii::$app->request->referrer);
        }
    }


    /**
     * @param mixed $type
     * @param Payment $model
     * @param mixed $id
     * @return void
     * @throws \yii\db\Exception
     */
    public function oneTimeServices(mixed $type, Payment $model, mixed $id): void
    {
        if ($type === 'ots') {
            $model->payment_type = Payment::PAYMENT_TYPE_FULL_PAYMENT;
            $model->payment_number = Payment::generateReference('OTS');
            $model->payment_date = date('Y-m-d');
            $model->created_at = date('Y-m-d');
            $model->updated_at = date('Y-m-d');
            $model->transaction_id = 'ots';
            if ($model->save(false)) {
                $ots = OneTimeServices::findOne($id);
                $ots->status = OneTimeServices::STATUS_PENDING;
                $ots->save(false);
                // send details for payment processing
            }
        }
    }

    /**
     * @param mixed $type
     * @param Payment $model
     * @param mixed $id
     * @return void
     * @throws \yii\db\Exception
     */
    public function reservations(mixed $type, Payment $model, mixed $id): void
    {
        if ($type === 'rsv') {
            $model->payment_type = Payment::PAYMENT_TYPE_INSTALLMENT;
            $model->payment_number = Payment::generateReference("RSV");
            $model->created_at = date('Y-m-d');
            $model->payment_date = date('Y-m-d');
            $model->updated_at = date('Y-m-d');
            $model->transaction_id = 'rsv';
            if ($model->save(false)) {
                $reservation = Reservation::findOne($id);
                $reservation->status = Reservation::STATUS_CONFIRMED;
                $reservation->amount_paid =$reservation->amount_paid + $model->amount;
                $reservation->balance_due =$reservation->balance_due - $model->amount;
                $reservation->save(false);
                // send details for payment processing
            }
        }
    }

    /**
     * @param mixed $type
     * @param mixed $id
     * @param Payment $model
     * @return void
     */
    public function prefillAmount(mixed $type, mixed $id, Payment $model): void
    {
        if ($type === 'ots') {
            $model->amount = OneTimeServices::findOne($id)->total_charge;
            $model->payable = OneTimeServices::findOne($id)->total_charge;
        }
        if($type ==='rsv'){
            $model->payable = Reservation::findOne($id)->balance_due;
        }
    }

    public function actionDetails($id = null)
    {
        $model = Reservation::findOne($id);
        $search = new PaymentSearch();
        $dataProvider = $search->search(['PaymentSearch' => ['reservation_id' => $id]]);
        $res = ['provider' => $dataProvider,
            'searchFields' => $search->searchFields(),
            'search' => $search,
            'export' => $search,
            'searchModel' => $dataProvider->getModels(),
            'title'=>'Customers',
            'model' => $model
        ];
        return $this->render('details', $res);
    }

    public function actionMakePayment($id = null)
    {
        try {
            $model = new BookingPayments();
            $bookingId = $id;
            $is = $model::findOne(['bookingId' => $bookingId]);
            if ($is) {
                Yii::$app->session->setFlash('error', "Booking Already Paid For");
                return $this->redirect('index');
            }
            if ($bookingId !== null) {
                $model->bookingId = $bookingId;
                $booking = Bookings::findOne($bookingId);
                $model->amount = Packages::findOne($booking->packageId)->economyPrice;
                if (!$booking) {
                    throw new NotFoundHttpException('The requested booking does not exist.');
                }
            }
            // Default values
            $model->currency = 'UGX';
            $model->payment_status = 'pending';
            $model->issuedBy = Yii::$app->user->id;
            $model->created_at = date('Y-m-d');
            $model->transaction_id = 'TRX-' . uniqid();
            if ($model->load(Yii::$app->request->post())) {
                // If currency is USD, ensure rate is set and actual_amount is calculated
                if (!($model->currency === 'USD' && $model->rate > 0)) {
                    $model->actual_amount = $model->amount;
                    $model->rate = "1";
                }
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Payment successfully recorded.');
//                    143
                    return $this->redirect(['booking-requests', 'id' => $model->bookingId]);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save payment.');
                }
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'An error occurred: ' . $e->getMessage());
            return $this->redirect(['index']);
        }
        return $this->render('make-payment', ['model' => $model,]);
    }

    public function actionArchivedBooking($id)
    {
        $booking = Bookings::findOne($id);
        $booking->is_archived = true;
        if ($booking->save(false)) {
            Yii::$app->session->setFlash('success', 'Booking Archived Successfully');
            return $this->redirect(['index']);;
        }
        Yii::$app->session->setFlash('error', 'Something went wrong. Please try again later.');
        return $this->redirect(['index']);;
    }

    public function actionPlaceBooking($id=null)
    {
        $model = $id ? Bookings::findOne($id) : new Bookings();
        if ($model->load(Yii::$app->request->post())) {
            // Check for existing booking with same userId and packageId
            $user = User::findOne($model->userId);
            $model->email = $user->email;
            $model->name = $user->name;
            $model->travelDocument = $user->NIN_or_Passport;
            $model->status = 'Pending';
            $model->is_archived = false;
            $model->c_year = date('Y');
            $existingBooking = Bookings::find()
                ->where(['userId' => $model->userId, 'packageId' => $model->packageId])
                ->andWhere(['<>', 'id', $id ?? 0])
                ->one();
            if ($existingBooking) {
                Yii::$app->session->setFlash('error', 'This user already has a booking for this package.');
                return $this->render('booking', [
                    'model' => $model,
                ]);
            }
            // Set timestamps
            $model->created_at = !$id ? date('Y-m-d H:i:s') : $model->created_at;
            $model->updated_at = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', !$id ? 'Booking created successfully.' : 'Booking updated successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('booking', [
            'model' => $model,
        ]);
    }

    public function actionBookingRequests($id = null)
    {
        if (!$id) {
            return $this->render('booking-requests', ['data' => []]);
        }
        $bookings = Bookings::find()->where(['id' => $id])->asArray()->one();
        if (!$bookings) {
            return $this->render('booking-requests', ['data' => []]);
        }

        $payments = BookingPayments::find()->where(['bookingId' => $bookings['id']])->asArray()->all();
        $client = User::find()->where(['id' => $bookings['userId']])->asArray()->one();

        $data = [
            'client' => $client,
            'bookings' => $bookings,
            'payments' => $payments
        ];

        return $this->render('booking-requests', ['data' => $data]);
    }

    public function actionSondaMpola()
    {
        $search = new SondaMpolaSearch();
        $dataProvider = $search->search(Yii::$app->request->post());
        $res = ['provider' => $dataProvider,
            'searchFields' => $search->searchFields(),
            'search' => $search,
            'export' => $search,
            'model' => $dataProvider->getModels()
        ];
        return $this->render('sonda-mpola', $res);
    }

    public function actionSondaAccount($id)
    {
        $data = SondaMpolas::find()->where(['id' => $id])->one();
        return $this->render('sonda-account', ['data' => $data]);
    }

    public function actionNewMpolaAccount($id = null)
    {
        $model = $id ? SondaMpolas::findOne($id) : new SondaMpolas();
        if ($model->load(Yii::$app->request->post())) {
            // Check for duplicate accounts
            $existingAccount = SondaMpolas::find()
                ->where(['account_number' => $model->mobileNo])
                ->andWhere(['<>', 'id', $model->id])
                ->one();

            if ($existingAccount) {
                Yii::$app->session->setFlash('error', 'Account number already exists');
            } else {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', ($model == 'update' ? 'Account updated' : 'Account created') . ' successfully');
                    return $this->redirect(['sonda-mpola']);
                }
            }
        }
        return $this->render('new-mpola-account', ['model' => $model,
        ]);
    }


}
