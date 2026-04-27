<?php

namespace app\controllers;

use app\models\Adverts;
use app\models\AdvertSearch;
use Yii;
use yii\web\UploadedFile;

class AdvertController extends BaseController
{
    public function actionIndex()
    {

        $search = new AdvertSearch();
        $dataProvider = $search->search(Yii::$app->request->post());
        $res = ['provider' => $dataProvider,
            'searchFields' => $search->searchFields(),
            'search' => $search,
            'export' => $search,
            'model' => $dataProvider->getModels()
        ];
        return $this->render('index', $res);
    }

    public function actionCreate($id = null)
    {
        $model = $id ? Adverts::findOne($id) : new Adverts();
        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'image');
            if ($model->save()) {
                if ($model->imageFile) {
                    $fileName = 'advert_' . $model->id . '.' . $model->imageFile->extension;
                    $model->imageFile->saveAs(Yii::getAlias('@webroot/uploads/adverts/') . $fileName);
                    $model->image = $fileName;
                    $model->save(false);
                }
                Yii::$app->session->setFlash('success', 'Advert ' . ($id ? 'updated' : 'created') . ' successfully');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Error ' . ($id ? 'updating' : 'saving') . ' advert');
            }
        }
        $res = ['model' => $model];
        return $this->render($id ? 'update' : 'create', $res);
    }

}
