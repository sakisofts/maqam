<?php

namespace app\controllers;

use app\models\TransactionSearch;
use Yii;

class TransactionsController extends BaseController
{

    public function actionIndex(){

        $search = new TransactionSearch();
        $dataProvider = $search->search(Yii::$app->request->post());
        $res = ['provider' => $dataProvider,
            'searchFields' => $search->searchFields(),
            'search' => $search,
            'export' => $search,
            'model' => $dataProvider->getModels()
        ];
        return $this->render('index', $res);

    }

}
