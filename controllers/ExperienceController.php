<?php

namespace app\controllers;

use app\models\MaqamExes;
use app\models\MaqamExesSearch;
use Yii;
use yii\web\UploadedFile;

class ExperienceController extends BaseController
{

    public function actionIndex(){
        $search = new MaqamExesSearch();
        $dataProvider = $search->search(Yii::$app->request->post());
        $res = ['provider' => $dataProvider,
            'searchFields' => $search->searchFields(),
            'search' => $search,
            'export' => $search,
            'model' => $dataProvider->getModels()
        ];
        return $this->render('index', $res);
    }

    public function actionCreate($id=null){
        $model  = $id ? MaqamExes::findOne($id) :new maqamExes();
        if($model->load(Yii::$app->request->post())){
            $uploadedFiles = UploadedFile::getInstances($model, 'image');
            if($uploadedFiles) {
                $fileUrls = [];
                foreach($uploadedFiles as $file) {
                    $fileName = time() . '_' . $file->baseName . '.' . $file->extension;
                    $filePath = 'uploads/experience/' . $fileName;
                    if($file->saveAs($filePath)) {
                        $fileUrls[] = $filePath;
                    }
                }
                $model->file_urls = implode(',', $fileUrls);
            }

            if($model->save()){
                Yii::$app->session->setFlash('success','Experience created successfully');
                return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('error','Error creating experience');
            }
        }        $res = ['model' => $model];
        return $this->render('create',$res);
    }


}
