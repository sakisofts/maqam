<?php

namespace app\controllers\api;

use app\models\Adverts;
use app\models\BookingPayments;
use app\models\Bookings;
use app\models\MaqamExes;
use app\models\Packages;
use app\models\SondaMpolaPayments;
use app\models\SondaMpolas;
use Yii;
use yii\helpers\FileHelper;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\db\Expression;
use app\models\User;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class MobileAppController extends ActiveController
{
    const USER_NOT_FOUND = 'User not found';
    public $modelClass = 'app\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Format response as JSON
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        // Define allowed HTTP methods
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'create-booking' => ['POST'],
                'get-user-bookings' => ['GET'],
                'update-booking-payment' => ['POST'],
                'get-packages' => ['GET'],
                'get-payment-history' => ['GET'],
                'fetch-client-travel-doc' => ['GET'],
                'fetch-adverts' => ['GET'],
                'fetch-maqam-experiences' => ['GET'],
                'login-client-in-app' => ['POST'],
                'register-client-via-app' => ['POST'],
                'login-into-sonda-mpola-account' => ['POST'],
                'create-sonda-mpola-payment-record' => ['POST'],
                'create-sonda-mpola-account' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        // Disable default actions
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    /**
     * Create a new booking
     * @return array
     */
    public function actionCreateBooking()
    {
        $request = Yii::$app->request->getBodyParams();

        $userId = $request['userId'] ?? null;
        $name = $request['name'] ?? null;
        $phone = $request['phone'] ?? null;
        $gender = $request['gender'] ?? null;
        $dob = $request['dob'] ?? null;
        $email = $request['email'] ?? null;
        $nationality = $request['nationality'] ?? null;
        $residence = $request['residence'] ?? null;
        $passportPhoto = $request['passportPhoto'] ?? null;
        $packageId = $request['packageId'] ?? null;
        $ninOrPassport = $request['ninOrPassport'] ?? null;

        if (!empty($userId)) {
            // identify user
            $user = User::find()
                ->select(['id', 'name', 'email', 'phone', 'role', 'gender', 'dob', 'nationality', 'residence', 'NIN_or_Passport', 'passportPhoto'])
                ->where(['id' => $userId])
                ->one();

            if (!$user) {
                Yii::$app->response->statusCode = 400;
                return ['message' => self::USER_NOT_FOUND];
            }

            $existingUserId = $user->id;

            // get user passport photo
            $passportPhotoPath = $user->passportPhoto;
            $passportPhotoUrl = Url::to('@web/bookingImages/' . $passportPhotoPath, true);

            // Include the image URL in your response
            $user->passportPhoto = $passportPhotoUrl;

            // create a new booking
            $newBooking = new Bookings();
            $newBooking->userId = $existingUserId;
            $newBooking->packageId = $packageId;
            $newBooking->bookingType = 'App';

            if ($newBooking->save()) {
                Yii::$app->response->statusCode = 200;
                return [
                    'message' => 'Booking saved successfully',
                    'user' => $user,
                    'booking_id' => $newBooking->id,
                ];
            } else {
                Yii::$app->response->statusCode = 400;
                return [
                    'message' => 'Booking failed',
                ];
            }
        } else {
            // if userId is empty, create an account for the user with their number as their password
            $currentDateTime = new Expression('NOW()');

            // Decode base64 image string
            $decoded_file = base64_decode($passportPhoto);
            $mime_type = $this->getMimeType($decoded_file);
            $extension = $this->mime2ext($mime_type);
            $file = uniqid() . '.' . $extension;

            try {
                $filePath = Yii::getAlias('@webroot/bookingImages/' . $file);
                file_put_contents($filePath, $decoded_file);
            } catch (\Exception $e) {
                Yii::$app->response->statusCode = 500;
                return ['message' => $e->getMessage()];
            }

            $user = new User();
            $user->name = $name;
            $user->email = $email ?? 'example@gmail.com';
            $user->phone = $phone;
            $user->password = Yii::$app->security->generatePasswordHash($phone);
            $user->role = 3;
            $user->gender = $gender;
            $user->dob = $dob ?? '12/01/1900';
            $user->nationality = $nationality;
            $user->residence = $residence;
            $user->NIN_or_Passport = $ninOrPassport;
            $user->passportPhoto = $file;
            $user->created_at = $currentDateTime;
            $user->updated_at = $currentDateTime;

            if (!$user->save()) {
                Yii::$app->response->statusCode = 400;
                return ['message' => 'Failed to create user', 'errors' => $user->errors];
            }

            $newUserId = $user->id;

            // Prepare user for response
            $responseUser = User::find()
                ->select(['id', 'name', 'email', 'phone', 'role', 'gender', 'dob', 'nationality', 'residence', 'NIN_or_Passport', 'passportPhoto'])
                ->where(['id' => $newUserId])
                ->one();

            if (!$responseUser) {
                Yii::$app->response->statusCode = 400;
                return ['message' => 'User not found'];
            }

            $passportPhotoUrl = Url::to('@web/bookingImages/' . $responseUser->passportPhoto, true);
            $responseUser->passportPhoto = $passportPhotoUrl;

            // create a new booking
            $newBooking = new Bookings();
            $newBooking->userId = $newUserId;
            $newBooking->packageId = $packageId;
            $newBooking->bookingType = 'App';

            if ($newBooking->save()) {
                Yii::$app->response->statusCode = 200;
                return [
                    'message' => 'Booking saved successfully',
                    'user' => $responseUser,
                    'booking_id' => $newBooking->id,
                ];
            } else {
                Yii::$app->response->statusCode = 400;
                return [
                    'message' => 'Booking failed',
                ];
            }
        }
    }

    /**
     * Get MIME type from content
     * @param string $content
     * @return string
     */
    protected function getMimeType($content)
    {
        if (empty($content)) {
            return false;
        }
        try {
            return FileHelper::getMimeType($content);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Convert mime type to file extension
     * @param string $mime
     * @return string|bool
     */
    protected function mime2ext($mime)
    {
        $mime_map = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/bmp' => 'bmp',
            'image/tiff' => 'tif',
            'application/pdf' => 'pdf',
            // Add more mime types as needed
        ];

        return isset($mime_map[$mime]) ? $mime_map[$mime] : 'jpg';
    }

    /**
     * Get bookings for a user
     * @return array
     */
    public function actionGetUserBookings()
    {
        $request = Yii::$app->request;
        $userId = $request->get('userId');

        if (!$userId) {
            throw new BadRequestHttpException('userId is required');
        }

        $page = $request->get('page', 1);
        $perPage = $request->get('perPage', 10);

        $query = Bookings::find()
            ->joinWith(['user', 'user.userRole', 'package'])
            ->select([
                'users.id as userId',
                'bookings.id as bookingId',
                'users.name',
                'users.phone',
                'users.email',
                'user_roles.Role',
                'users.gender',
                'users.dob',
                'users.nationality',
                'users.residence',
                'users.passportPhoto',
                'bookings.paymentOption',
                'packages.category',
                'bookings.created_at',
            ])
            ->where(['bookings.userId' => $userId])
            ->orderBy(['bookings.created_at' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'page' => $page - 1, 'pageSize' => $perPage]);

        $bookings = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        if (!empty($bookings)) {
            // Generate URL for passportPhoto images
            foreach ($bookings as &$booking) {
                            $uploadPath = Yii::getAlias('@webroot/bookingImages');
                            if (!file_exists($uploadPath)) {
                                mkdir($uploadPath, 0777, true);
                                chmod($uploadPath, 0777);
                            }
                            $booking['passportPhoto'] = Url::to('@web/bookingImages/' . $booking['passportPhoto'], true);
                        }

            return [
                'status' => true,
                'total' => $pages->totalCount,
                'current_page' => $page,
                'bookings' => $bookings,
            ];
        } else {
            return [
                'status' => false,
                'message' => 'No bookings found',
            ];
        }
    }

    /**
     * Update booking payment
     * @return array
     */
    public function actionUpdateBookingPayment()
    {
        $request = Yii::$app->request->getBodyParams();

        $bookingId = $request['bookingId'] ?? null;
        $paymentOption = $request['paymentOption'] ?? null;
        $bookingAmount = $request['amount'] ?? null;

        if (!$bookingId || !$paymentOption || !$bookingAmount) {
            throw new BadRequestHttpException('bookingId, paymentOption and amount are required');
        }

        $payments = new BookingPayments();
        $payments->bookingId = $bookingId;
        $payments->amount = $bookingAmount;
        $payments->paymentOption = $paymentOption;
        $payments->currency = 'UGX';
        $payments->actual_amount = $bookingAmount;

        try {
            if ($payments->save()) {
                return [
                    'status' => true,
                    'message' => "Payment Details updated"
                ];
            } else {
                Yii::$app->response->statusCode = 400;
                return [
                    'status' => false,
                    'message' => 'Failed to save payment details',
                    'errors' => $payments->errors
                ];
            }
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
            return [
                'status' => false,
                'message' => "Failed: " . $e->getMessage()
            ];
        }
    }

    /**
     * Get all packages
     * @return array
     */
    public function actionGetPackages()
    {
        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        $perPage = $request->get('perPage', 10);

        $query = Packages::find()->with('services')->orderBy(['created_at' => SORT_DESC]);
        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'page' => $page - 1, 'pageSize' => $perPage]);

        $packages = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        if (!empty($packages)) {
            // Format package images
            foreach ($packages as $package) {
                $package->packageImage = Url::to('@web/packageImages/' . $package->packageImage, true);

                // Format service images
                foreach ($package->services as $service) {
                    $service->image = Url::to('@web/packageImages/' . $service->image, true);
                }
            }

            return [
                'status' => true,
                'total' => $pages->totalCount,
                'current_page' => $page,
                'packages' => $packages,
            ];
        } else {
            return [
                'status' => false,
                'message' => 'No Packages found',
            ];
        }
    }

    /**
     * Get payment history for a booking
     * @return array
     */
    public function actionGetPaymentHistory()
    {
        $bookId = Yii::$app->request->get('bookingId');

        if (!$bookId) {
            throw new BadRequestHttpException('bookingId is required');
        }

        $payments = BookingPayments::find()
            ->select([
                'amount',
                'payment_status',
                'paymentOption',
                'created_at'
            ])
            ->where(['bookingId' => $bookId])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        if (!empty($payments)) {
            return [
                'status' => true,
                'payments' => $payments,
            ];
        } else {
            return [
                'status' => false,
                'message' => 'No payments made yet',
            ];
        }
    }

    /**
     * Get travel document for a client
     * @return array
     */
    public function actionFetchClientTravelDoc()
    {
        $bookId = Yii::$app->request->get('bookingId');

        if (!$bookId) {
            throw new BadRequestHttpException('bookingId is required');
        }

        $booking = Bookings::find()->select(['travelDocument'])->where(['id' => $bookId])->one();

        if (!$booking) {
            Yii::$app->response->statusCode = 404;
            return ['error' => 'Document path not found.'];
        }

        $path = $booking->travelDocument;

        if ($path != null) {
            $filePath = Url::to('@web/travelDocuments/' . $path, true);
            return [
                'status' => true,
                'file_path' => $filePath,
            ];
        } else {
            return [
                'status' => false,
                'message' => "Travel Documents not yet uploaded.",
            ];
        }
    }

    /**
     * Get all adverts
     * @return array
     */
    public function actionFetchAdverts()
    {
        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        $perPage = $request->get('perPage', 10);

        $query = Adverts::find();
        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'page' => $page - 1, 'pageSize' => $perPage]);

        $adverts = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        if (!empty($adverts)) {
            foreach ($adverts as $advert) {
                $advert->image = Url::to('@web/advertImages/' . $advert->image, true);
            }

            return [
                'status' => true,
                'total' => $pages->totalCount,
                'current_page' => $page,
                'adverts' => $adverts,
            ];
        } else {
            return [
                'status' => false,
                'message' => 'No Adverts found',
            ];
        }
    }

    /**
     * Get all maqam experiences
     * @return array
     */
    public function actionFetchMaqamExperiences()
    {
        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        $perPage = $request->get('perPage', 10);

        $query = MaqamExes::find();
        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'page' => $page - 1, 'pageSize' => $perPage]);

        $experiences = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        if (!empty($experiences)) {
            foreach ($experiences as $experience) {
                $experience->thumbnail = Url::to('@web/maqamExpImages/' . $experience->thumbnail, true);
            }

            return [
                'status' => true,
                'total' => $pages->totalCount,
                'current_page' => $page,
                'experiences' => $experiences,
            ];
        } else {
            return [
                'status' => false,
                'message' => 'No Maqam Experiences found',
            ];
        }
    }

    /**
     * Login client in app
     * @return array
     */
    public function actionLoginClientInApp()
    {
        $request = Yii::$app->request->getBodyParams();

        $phone = $request['phone'] ?? null;
        $password = $request['password'] ?? null;

        if (!$phone || !$password) {
            throw new BadRequestHttpException('phone and password are required');
        }

        $user = User::findOne(['phone' => $phone]);

        if (!$user || !Yii::$app->security->validatePassword($password, $user->password)) {
            Yii::$app->response->statusCode = 401;
            return ['message' => 'Invalid phone number or password'];
        }

        // Construct the passport photo URL
        $passportPhotoUrl = Url::to('@web/bookingImages/' . $user->passportPhoto, true);
        $user->passportPhoto = $passportPhotoUrl;

        return [
            'message' => 'Successful login',
            'user' => $user,
        ];
    }

    /**
     * Register client via app
     * @return array
     */
    public function actionRegisterClientViaApp()
    {
        $request = Yii::$app->request->getBodyParams();

        // Validate incoming request data
        $requiredFields = [
            'name', 'phone', 'password', 'gender', 'dob', 'email',
            'nationality', 'residence', 'passportPhoto', 'ninOrPassport'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($request[$field]) || empty($request[$field])) {
                throw new BadRequestHttpException("Field {$field} is required");
            }
        }

        $currentDateTime = new Expression('NOW()');

        // Decode base64 image string
        $decoded_file = base64_decode($request['passportPhoto']);
        $mime_type = $this->getMimeType($decoded_file);
        $extension = $this->mime2ext($mime_type);
        $file = uniqid() . '.' . $extension;

        try {
            $filePath = Yii::getAlias('@webroot/bookingImages/' . $file);
            file_put_contents($filePath, $decoded_file);
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
            return ['message' => $e->getMessage()];
        }

        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->password = Yii::$app->security->generatePasswordHash($request['password']);
        $user->role = 3;
        $user->gender = $request['gender'];
        $user->dob = $request['dob'];
        $user->nationality = $request['nationality'];
        $user->residence = $request['residence'];
        $user->NIN_or_Passport = $request['ninOrPassport'];
        $user->passportPhoto = $file;
        $user->created_at = $currentDateTime;
        $user->updated_at = $currentDateTime;

        if (!$user->save()) {
            Yii::$app->response->statusCode = 400;
            return [
                'message' => 'Failed to create user',
                'errors' => $user->errors
            ];
        }

        $newUser = User::find()
            ->select(['id', 'name', 'email', 'phone', 'role', 'gender', 'dob', 'nationality', 'residence', 'NIN_or_Passport', 'passportPhoto'])
            ->where(['id' => $user->id])
            ->one();

        if (!$newUser) {
            Yii::$app->response->statusCode = 400;
            return ['message' => 'User not found'];
        }

        // Construct the passport photo URL
        $passportPhotoUrl = Url::to('@web/bookingImages/' . $newUser->passportPhoto, true);
        $newUser->passportPhoto = $passportPhotoUrl;

        return [
            'message' => 'Maqam Account Created successfully',
            'user' => $newUser,
        ];
    }

    /**
     * Login into Sonda Mpola account API
     * @return array
     */
    public function actionLoginIntoSondaMpolaAccount()
    {
        $request = Yii::$app->request->getBodyParams();

        $reference = $request['reference'] ?? null;

        if (!$reference) {
            throw new BadRequestHttpException('reference is required');
        }

        $user = SondaMpolas::find()->where(['reference' => $reference])->one();

        if (!$user) {
            Yii::$app->response->statusCode = 400;
            return ['message' => 'User not found'];
        }

        // Construct the passport photo URL
        $passportPhotoUrl = Url::to('@web/sondaMpola/' . $user->image, true);
        $user->image = $passportPhotoUrl;

        $sondaMpolaId = $user->id;

        $amountDepositedSoFar = $this->getTotalAmountSondaMpolaUserHasSaved($sondaMpolaId);
        $userPendingBalance = $this->getSondaMpolaUserLatestBalance($sondaMpolaId);

        $payments = SondaMpolaPayments::find()
            ->joinWith(['issuedByUser', 'sondaMpola'])
            ->select([
                'sonda_mpola_payments.id',
                'sonda_mpola_payments.amount',
                'sonda_mpola_payments.payment_option',
                'sonda_mpola_payments.created_at',
                'sonda_mpola_payments.payment_status',
                'sonda_mpolas.umrahSavingTarget',
                'sonda_mpolas.hajjSavingTarget',
                'sonda_mpola_payments.balance',
                'users.name as issued_by_name'
            ])
            ->where(['sonda_mpola_payments.sondaMpolaId' => $sondaMpolaId])
            ->orderBy(['sonda_mpola_payments.created_at' => SORT_DESC])
            ->all();

        return [
            'message' => 'Sonda Mpola Account Login successful',
            'sondaMpolaId' => $sondaMpolaId,
            'account' => $user,
            'payments' => $payments,
            'amountDepositedSoFar' => $amountDepositedSoFar,
            'userPendingBalance' => $userPendingBalance,
        ];
    }

    /**
     * Get total amount user has saved
     * @param int $sondaMpolaId
     * @return float
     */
    protected function getTotalAmountSondaMpolaUserHasSaved($sondaMpolaId)
    {
        return SondaMpolaPayments::find()
            ->where(['sondaMpolaId' => $sondaMpolaId])
            ->sum('actual_amount') ?? 0;
    }

    /**
     * Get user's latest balance
     * @param int $sondaMpolaId
     * @return float|null
     */
    protected function getSondaMpolaUserLatestBalance($sondaMpolaId)
    {
        $record = SondaMpolaPayments::find()
            ->select(['balance'])
            ->where(['sondaMpolaId' => $sondaMpolaId])
            ->orderBy(['updated_at' => SORT_DESC])
            ->one();

        return $record ? $record->balance : null;
    }

    /**
     * Create Sonda Mpola payment record
     * @return array
     */
    public function actionCreateSondaMpolaPaymentRecord()
    {
        $request = Yii::$app->request->getBodyParams();

        $authId = $request['authId'] ?? null;
        $sondaMpolaId = $request['sondaMpolaId'] ?? null;
        $amount = $request['amount'] ?? null;
        $paymentOption = $request['paymentOption'] ?? null;

        if (!$authId || !$sondaMpolaId || !$amount || !$paymentOption) {
            throw new BadRequestHttpException('All fields are required');
        }

        $userTargetAmount = SondaMpolas::find()->select(['targetAmount'])->where(['id' => $sondaMpolaId])->one();

        if (!$userTargetAmount) {
            throw new NotFoundHttpException('Sonda Mpola account not found');
        }

        if ($amount > $userTargetAmount->targetAmount) {
            Yii::$app->response->statusCode = 400;
            return ['message' => 'Amount Greater than Target amount, Please try again with less amount.'];
        }

        $actualAmount = (float)$amount;

        // Calculate balance
        $totalSaved = $this->getTotalAmountSondaMpolaUserHasSaved($sondaMpolaId);
        $balance = $userTargetAmount->targetAmount - ($totalSaved + $actualAmount);

        // Create new payment record
        $payment = new SondaMpolaPayments();
        $payment->sondaMpolaId = $sondaMpolaId;
        $payment->amount = $amount;
        $payment->payment_option = $paymentOption;
        $payment->currency = 'UGX';
        $payment->actual_amount = $actualAmount;
        $payment->balance = $balance;
        $payment->receipted_by = $authId;
        $payment->created_at = new Expression('NOW()');
        $payment->updated_at = new Expression('NOW()');

        if ($payment->save()) {
            return [
                'message' => 'Sonda Mpola Payment record saved successfully!',
            ];
        } else {
            Yii::$app->response->statusCode = 400;
            return [
                'message' => 'Failed to save Sonda Mpola payment record. Please try again.',
                'errors' => $payment->errors
            ];
        }
    }

    /**
     * Create Sonda Mpola account
     * @return array
     */
    public function actionCreateSondaMpolaAccount()
    {
        try {
            $request = Yii::$app->request->getBodyParams();

            // Validate required fields
            $requiredFields = [
                'name', 'identificationType', 'nin_or_passport', 'dateOfExpiry',
                'phone', 'email', 'savingFor', 'targetAmount', 'gender', 'dob',
                'placeOfBirth', 'fatherName', 'motherName', 'maritalStatus',
                'country', 'nationality', 'residence', 'district', 'county',
                'subcounty', 'parish', 'village', 'nextOfKin', 'relationship',
                'nextOfKinAddress', 'mobileNo', 'authId', 'image'
            ];

            foreach ($requiredFields as $field) {
                if (!isset($request[$field]) || empty($request[$field])) {
                    throw new BadRequestHttpException("Field {$field} is required");
                }
            }

            // Validate saving type
            if (!in_array($request['savingFor'], ['Umrah', 'Hajj'])) {
                throw new BadRequestHttpException("savingFor must be either 'Umrah' or 'Hajj'");
            }

            // Handle image upload
            $decoded_file = base64_decode($request['image']);
            $mime_type = $this->getMimeType($decoded_file);
            $extension = $this->mime2ext($mime_type);
            $file = uniqid() . '.' . $extension;

            try {
                $filePath = Yii::getAlias('@webroot/sondaMpola/' . $file);
                file_put_contents($filePath, $decoded_file);
            } catch (\Exception $e) {
                Yii::$app->response->statusCode = 500;
                return ['message' => $e->getMessage()];
            }

            // Reference generation logic
            $referencePrefix = 'SM/';
            $referenceMiddle = '';

            // Determine middle part based on savingFor and the saving target selected
            if ($request['savingFor'] == 'Umrah') {
                $referenceMiddle = 'UMRAH/';
            } else if ($request['savingFor'] == 'Hajj') {
                $referenceMiddle = 'HAJJ/';
            }

            // Generate a unique reference number with date and random digits
            $referenceSuffix = date('Ymd') . '/' . rand(1000, 9999);
            $reference = $referencePrefix . $referenceMiddle . $referenceSuffix;

            // Create new Sonda Mpola account
            $sondaMpola = new SondaMpolas();
            $sondaMpola->name = $request['name'];
            $sondaMpola->identificationType = $request['identificationType'];
            $sondaMpola->nin_or_passport = $request['nin_or_passport'];
            $sondaMpola->dateOfExpiry = $request['dateOfExpiry'];
            $sondaMpola->phone = $request['phone'];
            $sondaMpola->email = $request['email'];
            $sondaMpola->savingFor = $request['savingFor'];
            $sondaMpola->targetAmount = $request['targetAmount'];
            $sondaMpola->gender = $request['gender'];
            $sondaMpola->dob = $request['dob'];
            $sondaMpola->placeOfBirth = $request['placeOfBirth'];
            $sondaMpola->fatherName = $request['fatherName'];
            $sondaMpola->motherName = $request['motherName'];
            $sondaMpola->maritalStatus = $request['maritalStatus'];
            $sondaMpola->country = $request['country'];
            $sondaMpola->nationality = $request['nationality'];
            $sondaMpola->residence = $request['residence'];
            $sondaMpola->district = $request['district'];
            $sondaMpola->county = $request['county'];
            $sondaMpola->subcounty = $request['subcounty'];
            $sondaMpola->parish = $request['parish'];
            $sondaMpola->village = $request['village'];
            $sondaMpola->nextOfKin = $request['nextOfKin'];
            $sondaMpola->relationship = $request['relationship'];
            $sondaMpola->nextOfKinAddress = $request['nextOfKinAddress'];
            $sondaMpola->mobileNo = $request['mobileNo'];
            $sondaMpola->image = $file;
            $sondaMpola->reference = $reference;

            // Set Umrah or Hajj saving target based on savingFor
            if ($request['savingFor'] == 'Umrah') {
                $sondaMpola->umrahSavingTarget = $request['targetAmount'];
                $sondaMpola->hajjSavingTarget = 0;
            } else {
                $sondaMpola->hajjSavingTarget = $request['targetAmount'];
                $sondaMpola->umrahSavingTarget = 0;
            }

            $sondaMpola->registeredBy = $request['authId'];
            $sondaMpola->created_at = new Expression('NOW()');
            $sondaMpola->updated_at = new Expression('NOW()');

            if ($sondaMpola->save()) {
                // Return success response with account details
                $imageUrl = Url::to('@web/sondaMpola/' . $file, true);

                return [
                    'message' => 'Sonda Mpola Account created successfully',
                    'account' => [
                        'id' => $sondaMpola->id,
                        'name' => $sondaMpola->name,
                        'reference' => $sondaMpola->reference,
                        'phone' => $sondaMpola->phone,
                        'email' => $sondaMpola->email,
                        'savingFor' => $sondaMpola->savingFor,
                        'targetAmount' => $sondaMpola->targetAmount,
                        'image' => $imageUrl,
                        'created_at' => $sondaMpola->created_at
                    ]
                ];
            } else {
                Yii::$app->response->statusCode = 400;
                return [
                    'message' => 'Failed to create Sonda Mpola account',
                    'errors' => $sondaMpola->errors
                ];
            }
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
            return [
                'message' => 'Error creating Sonda Mpola account: ' . $e->getMessage(),
                'trace' => YII_DEBUG ? $e->getTraceAsString() : null
            ];
        }
    }
}
