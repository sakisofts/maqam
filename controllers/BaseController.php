<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class BaseController extends Controller
{

    private $_isGuest = null;
    private $_user = null;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'authRedirect' => [
                'class' => 'app\components\behaviors\AuthRedirectBehavior',
                'redirectController' => 'landing',
                'redirectAction' => 'login',
                'excludeControllers' => ['landing'],
                'excludeActions' => ['logout', 'error', 'login', 'index'],
            ],
        ];
    }

    public function beforeAction($action){
        if($this->action->controller->id !== 'landing' && !Yii::$app->user->identity) {
            Yii::$app->user->logout();
            return $this->redirect(['landing/login']);

        }
        return parent::beforeAction($action);
    }





}
