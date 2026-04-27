<?php

namespace app\controllers;

use app\models\LoginForm;
use yii\web\Controller;

class LandingController extends BaseController
{
    public $layout = 'Landing';

    public function actionIndex(){
        return $this->render('index');
    }

    public function actionCancellationRefundPolicy(){
        return $this->render('cancel');
    }

    public function actionLogin(){
        $this->layout = 'Auth';
        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/site/index']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
}
