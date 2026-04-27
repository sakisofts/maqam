<?php

namespace app\controllers;

use app\models\Amenities;
use app\models\MasterPackage;
use app\models\MasterPackageSearch;
use app\models\Packages;
use app\models\PackageSearch;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

class PackageController extends BaseController
{

    public function actionIndex()
    {
        $search = new PackageSearch();
        $dataProvider = $search->search(Yii::$app->request->post());
        $res = ['provider' => $dataProvider,
            'searchFields' => $search->searchFields(),
            'search' => $search,
            'export' => $search,
            'model' => $dataProvider->getModels()
        ];
        return $this->render('index', $res);
    }

    public function actionArchive($id){
        $booking = Packages::findOne($id);
        $booking->is_archived=true;
        if($booking->save(false)){
            Yii::$app->session->setFlash('success', 'Package Archived Successfully');
            return $this->redirect(['index']);;
        }
        Yii::$app->session->setFlash('error', 'Something went wrong. Please try again later.');
        return $this->redirect(['index']);;
    }

    public function actionMaster()
    {
        $search = new MasterPackageSearch();
        $dataProvider = $search->search(Yii::$app->request->post());
        $res = ['provider' => $dataProvider,
            'searchFields' => $search->searchFields(),
            'search' => $search,
            'export' => $search,
            'model' => $dataProvider->getModels()
        ];
        return $this->render('master', $res);
    }
    public function actionMasterCreate($id = null)
    {
        $model = $id ? (new MasterPackage())::findOne($id) : new MasterPackage();
        if ($model->load(Yii::$app->request->post())) {
            // Handle image upload
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            // Attempt to upload image and save model
            if ($model->upload() && $model->save()) {
                Yii::$app->session->setFlash('success', 'Package has been created successfully.');
                return $this->redirect(['master', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error saving the package.');
            }
        }

        return $this->render('create_master', [
            'model' => $model,
        ]);
    }

    public function actionCreate($id = null)
    {
        $model = $id ? Packages::findOne($id) : new Packages();
        if ($model->load(Yii::$app->request->post())) {
            $mk = $model->Mpk($model->mpId);
            $model->packageImage = $mk->package_image;
            $model->economyPrice = $model->standardPrice;
            $model->is_archived=false;
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Package saved successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model ?? new Packages(),
            'amenities' => (new Amenities())::getAmenitiesForForm()
        ]);

    }


}
