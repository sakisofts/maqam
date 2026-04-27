<?php

namespace app\controllers;

use app\models\Users;
use Yii;

class UserController extends BaseController
{


    public function actionProfile(){

        $model = Users::findOne(Yii::$app->user->identity->id);
        $model->setScenario('update');
        if ($model->load(Yii::$app->request->post())) {
            $model->password = Yii::$app->security->generatePasswordHash($model->password);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully');
                return $this->redirect(['profile']);
            } else {
                Yii::$app->session->setFlash('error', 'Profile update failed');
            }
        }
        return $this->render('profile', ['model' => $model]);

    }

    public function actionChangePassword(){
        $model = Users::findOne(Yii::$app->user->identity->id);
        $model->setScenario('changePassword');
        if ($model->load(Yii::$app->request->post())) {
            $model->password = Yii::$app->security->generatePasswordHash($model->password);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Password changed successfully');
                return $this->redirect(['profile']);
            } else {
                Yii::$app->session->setFlash('error', 'Password change failed');
            }
        }
        return $this->render('change-password', ['model' => $model]);
    }


    public function actionEnable2fa(){
        $model = Users::findOne(Yii::$app->user->identity->id);
        $model->setScenario('enable2fa');
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            Yii::$app->session->setFlash('success', '2FA enabled successfully');
            return $this->redirect(['profile']);
        }
        return $this->render('enable-2fa', ['model' => $model]);
    }

    public function actionVerifyEmail($id){
        $model = Users::findOne(Yii::$app->user->identity->id);
        $model->setScenario('verifyEmail');
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            Yii::$app->session->setFlash('success', 'Email verified successfully');
            return $this->redirect(['profile']);
        }
        return $this->render('verify-email', ['model' => $model]);
    }


}
