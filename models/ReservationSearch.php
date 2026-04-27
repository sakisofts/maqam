<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Html;

class ReservationSearch extends Reservation implements SearchInterface
{
    public function rules()
    {
        return [
            [['user_id', 'package_id', 'total_amount', 'status', 'id'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return parent::scenarios();
    }

    public function search($params = null)
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
                    'reservation.id' => SORT_DESC,
                ],
                'attributes' => [
                    'reservation.id'
                ]
            ]
        ]);

        if ($params) {
            $this->load($params);
        }
        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($params['ReservationSearch'])) {

            $query->andFilterWhere([
                'LOWER(reservation.package_id)' => strtolower($this->package_id),
                'LOWER(reservation.total_amount)' => strtolower($this->total_amount),
            ]);

        }

        Yii::$app->session->set("data", $dataProvider->getModels());
        return $dataProvider;


    }

    public function ql()
    {
        return (new Query())->select(['*'])->from('reservation');

//            ->innerJoin('users', 'reservation.user_id = users.id')
//            ->innerJoin('master_package', 'reservation.package_id = master_package.id');
    }

    public function searchFields()
    {
        return [
            'user_id' => [
                'type' => 'select',
                'placeholder' => 'Search by user',
                'options' => Users::find()->select(['name', 'id'])->indexBy('id')->column(),
                'name' => 'user_id',
            ],
            'package_id' => [
                'type' => 'text',
                'placeholder' => 'Search by package name',
                'name' => 'package_id',
            ],
            'total_amount' => [
                'type' => 'text',
                'placeholder' => 'Search by Reservation Fee',
                'name' => 'total_amount',
            ]
        ];
    }

    public function getData()
    {
        return Yii::$app->session->get("data") ?? $this->ql()->all();
    }

    public function ExportColumns()
    {
        return [
            'reservation_number' => 'RSV.NO',
            'user_id' => [
                'label' => 'Customer',
                'format' => function ($value) {
                    return $value ? ucfirst(Users::findOne($value)->name) : '';
                }
            ],
            'package_id' => [
                'label' => 'Package',
                'format' => function ($value) {
                    return $value ? ucfirst(MasterPackage::findOne($value)->package_name) : '';
                }
            ],
            'reservation_date' => [
                'label' => 'RSV.Date',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }
            ],
            'payment_deadline' => 'Deadline',
            'total_amount' => [
                'label'=>'Total Amount',
                'format'=>function ($value) {
                    return $value ? Yii::$app->formatter->asCurrency($value, 'USD') : '';
                }
            ],
            'amount_paid' => [
                'label'=>'Amount Paid',
                'format'=>function ($value) {
                  return $value ? Yii::$app->formatter->asCurrency($value, 'USD') : '';
                }
            ],
            'balance_due' => [
                'label'=>'Balance Due',
                 'format'=>function ($value) {
                    return $value ? Yii::$app->formatter->asCurrency($value, 'USD') : '';
                 }
            ],
            'status' => 'Status',
            'special_requests' => 'Special Requests',
            'created_at' => [
                'label' => 'Dated On',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }
            ],
        ];
    }

    public function tableColumns()
    {
        return [
            'reservation_number' => 'RSV.NO',
            'user_id' => [
                'label' => 'Customer',
                'format' => function ($value) {
                    return $value ? ucfirst(Users::findOne($value)->name) : '';
                }
            ],
            'package_id' => [
                'label' => 'Package',
                'format' => function ($value) {
                    return $value ? ucfirst(MasterPackage::findOne($value)->package_name) : '';
                }
            ],
            'reservation_date' => [
                'label' => 'RSV.Date',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }
            ],
            'payment_deadline' => 'Deadline',
            'total_amount' => [
                'label'=>'Total Amount',
                'format'=>function ($value) {
                    return $value ? Yii::$app->formatter->asCurrency($value, 'USD') : '';
                }
            ],
            'amount_paid' => [
                'label'=>'Amount Paid',
                'format'=>function ($value) {
                    return $value ? Yii::$app->formatter->asCurrency($value, 'USD') : '';
                }
            ],
            'balance_due' => [
                'label'=>'Balance Due',
                'format'=>function ($value) {
                    return $value ? Yii::$app->formatter->asCurrency($value, 'USD') : '';
                }
            ],
            'status' => 'Status',
            'created_at' => [
                'label' => 'Dated On',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }
            ],
            'action' => [
                'label' => 'Action',
                'actions' => [
                    function ($data) {
                        return Html::a('<i class="fa fa-eye"></i>', ['details', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'View Details']);
                    } ,
                    function ($data) {
                        return Html::a('<i class="fa fa-edit"></i>', ['reserve-create', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'Edit']);
                    }
                ]
            ]

        ];
    }
}
