<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Html;

class MasterPackageSearch extends MasterPackage implements SearchInterface
{

    public function scenarios()
    {
        return parent::scenarios();
    }

    public function ql(){
        return (new Query())->select(['*'])->from('master_package');
    }

    public function search($params=null)
    {
        Yii::$app->session->remove("data");
        $query = $this->ql();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
                'attributes' => [
                    'id'
                ],
            ],
        ]);

        if ($params) {
            $this->load($params);
        }

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($params['MasterPackageSearch'])) {

            $query->andFilterWhere([
                'LOWER(package_name)' => strtolower($this->package_name),
                'LOWER(reservation_fee)' =>strtolower($this->reservation_fee),
            ]);

        }

        Yii::$app->session->set("data", $dataProvider->getModels());
        return $dataProvider;


    }

    public function searchFields()
    {
        return [
            'package_name' => [
                'type' => 'text',
                'placeholder' => 'Search by package name',
                'name' => 'package_name',
            ],
            'reservation_fee' => [
                'type' => 'text',
                'placeholder' => 'Search by Reservation Fee',
                'name' => 'reservation_fee',
            ]
        ];
    }

    public function getData()
    {
        return yii::$app->session->get("data") ?? $this->ql()->all();
    }

    public function ExportColumns()
    {
        return [
            'package_name' => 'Package Name',
            'reservation_fee' => 'Reservation Fee',
            'created_at' => [
                'label' => 'Date Created',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }
            ]
        ];
    }

    public function tableColumns()
    {
      return [
            'package_name' => 'Package Name',
            'reservation_fee' => [
                'label' => 'Reservation Fee',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asCurrency($value, 'USD') : '-';
                }
            ],
            'created_at' => [
                'label' => 'Date Created',
                 'format' => function ($value) {
                   return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '-';
                 }
            ]
            ,'action' => [
              'label' => 'Action',
              'actions' => [
                  function ($data) {
                      return Html::a('<i class="fa fa-edit"></i>', ['master-create', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'Update details']);
                  },
                  function ($data) {
                      return Html::a('<i class="fa fa-archive"></i>', ['archive', 'id' => $data['id']],
                          [
                              'class' => 'btn btn-outline-danger btn-sm',
                              'title' => 'Archive account',
                              'data' => [
                                  'confirm' => 'Are you sure you want to Archive this item?',
                                  'method' => 'post'
                              ]
                          ]);
                  }]
         ]];

    }
}
