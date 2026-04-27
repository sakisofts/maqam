<?php

namespace app\controllers;
use app\models\BookingPayments;
use app\models\Bookings;
use app\models\PasswordChangeForm;
use app\models\SondaMpolaPayments;
use app\models\SondaMpolas;
use app\models\Transaction;
use app\models\TwoFactorAuthForm;
use app\models\User;
use app\models\UserProfile;
use app\models\UserSearch;
use Yii;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return Response
     */
    public function actionIndex()
    {
//        $res = (new Bookings())->bookings();

        $request = Yii::$app->request;
        if (!$request->isPost) {
            return $this->asJson(['message' => 'running']);
        }else{
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


        return $this->asJson(['connected'=>"running"]);
    }

    public function actionUserDetails($id){

        $res = [
            'model' => User::findOne($id),
            'profile'=>UserProfile::findOne(['userId'=>$id]) ?? new UserProfile(),
            'passwordForm' => new PasswordChangeForm(),
            'twoFactorForm'=>new TwoFactorAuthForm(Yii::$app->user->identity),
        ];
        return $this->render('profile', $res);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionUsers()
    {
        $search = new UserSearch();
        $dataProvider = $search->search(Yii::$app->request->post(),'admin');;
        $res = ['provider' => $dataProvider,
            'searchFields' => $search->searchFields(),
            'search' => $search,
            'export' => $search,
            'model' => $dataProvider->getModels(),
            'title'=>'System users'
        ];
        return $this->render('users', $res);
    }

   public function actionClients()
    {
        $search = new UserSearch();
        $dataProvider = $search->search(Yii::$app->request->post(),'client');
        $res = ['provider' => $dataProvider,
            'searchFields' => $search->searchFields(),
            'search' => $search,
            'export' => $search,
            'model' => $dataProvider->getModels(),
            'title'=>'Customers'
        ];
        return $this->render('users', $res);
    }


    public function actionCreateUser($id=null){
        $model = $id ? User::findOne($id) : new User();
        if ($model->load(Yii::$app->request->post())) {
            $existingUser = User::findOne(['email' => $model->email]);
            if ($existingUser && $existingUser->id !== $model->id) {
                Yii::$app->session->setFlash('error', "User with this email already exists");
                return $this->render('create-user', ['model' => $model]);
            }
            $image = UploadedFile::getInstance($model, 'image');
            if ($image) {
                $uploadDir = Yii::getAlias('@webroot/web/images/');

                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                    chmod($uploadDir, 0777);
                }

                $imageName = 'user_' . time() . '_' . uniqid() . '.' . $image->extension;
                $imagePath = $uploadDir . $imageName;

                try {
                    if ($image->saveAs($imagePath)) {
                        // Remove old image if exists
                        if ($model->image_path && file_exists(Yii::getAlias('@webroot') . $model->image_path)) {
                            unlink(Yii::getAlias('@webroot') . $model->image_path);
                        }

                        $model->image_path = '/web/images/' . $imageName;
                    } else {
                        throw new \Exception("Failed to save image");
                    }
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', "Failed to upload image: " . $e->getMessage());
                    return $this->render('create-user', ['model' => $model]);
                }
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', ($id ? "User updated" : "User created") . " successfully");
                return $this->redirect(Yii::$app->request->referrer);;
            }
        }        return $this->render('create-user', [
            'model' => $model,
        ]);
    }


}
