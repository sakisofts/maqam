<?php

namespace app\models;

use app\components\Generics\CrossHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class BookingSearch extends Bookings implements SearchInterface
{

    public function rules(): array
    {

        return [
            [['name', 'packageId', 'email', 'title', 'payment_status', 'is_archived', 'status', 'phone', 'userId', 'bookingType', 'category', 'paymentOption', 'id'], 'safe'],
        ];

    }

    public function scenarios()
    {
        return parent::scenarios();
    }

    public function search($params = null): ActiveDataProvider
    {

        $this->load($params);
        Yii::$app->session->remove("data");
        // Create the base query with all needed joins
        $query = $this->ql();
        if (!$params) {
            $query->where(['b.is_archived' => 0]);
        }
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
                ]
            ],
        ]);


        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($params['BookingSearch'])) {
            // Fix the column references in the where conditions
            $query->orFilterWhere([
                'like', 'LOWER(b.bookingType)', strtolower($this->bookingType)
            ])
                ->orFilterWhere([
                    'like', 'LOWER(b.paymentOption)', strtolower($this->paymentOption)
                ])
                ->orFilterWhere([
                    'b.userId' => $this->userId
                ])->orFilterWhere([
                    'b.packageId' => $this->packageId
                ])->orFilterWhere([
                    'b.is_archived', $this->is_archived
                ]);
        }

        Yii::$app->session->set("data", $dataProvider->getModels());

        return $dataProvider;
    }

    public function ql()
    {
        return (new Query())->from('bookings b')->select([
            'b.*',
            'u.name AS name',
            'u.phone',
            'u.email AS email',
            'p.title',
            'p.category AS category',
        ])
            ->innerJoin('users u', 'b.userId = u.id')
            ->leftJoin('packages p', 'b.packageId = p.id');
    }

    public function searchFields()
    {
        $fields = [
            'userId' => [
                'type' => 'select',
                'placeholder' => 'Search by User',
                'name' => 'userId',
                'options' => ArrayHelper::map(CrossHelper::customers(), 'id', 'name'),
            ],
            'packageId' => [
                'type' => 'select',
                'placeholder' => 'Search by Package',
                'name' => 'packageId',
                'options' => ArrayHelper::map(Packages::find()->all(), 'id', 'title'),
            ],
            'is_archived' => [
                'type' => 'select',
                'placeholder' => 'Search by Status',
                'options' => [
                    '0' => 'Active',
                    '1' => 'Archived',
                ],
                'name' => 'is_archived',
            ],

        ];
        return $fields;
    }

    public function getData()
    {
        return yii::$app->session->get("data") ?? $this->ql()->all();
    }

    public function ExportColumns()
    {
        return [
            'name' => 'User Name',
//            'category' => 'Booked Package',
            'title' => 'Booked Package',
            'bookingType' => 'Type',
            'status' => 'Status',
            'c_year' => [
                'label' => 'Year',
                'format' => function ($value) {
                    return $value ? $value : '-';
                }
            ],
            'created_by' => [
                'label' => 'Created By',
                'format' => function ($value) {
                    return $value ? CrossHelper::username($value) : '-';
                }
            ],
            'created_at' => [
                'label' => 'Created',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '-';
                }
            ],
        ];
    }

    public function tableColumns()
    {
        $col = [
            'name' => 'Client Name',
            'phone' => 'Mobile',
//            'category' => 'Booked Package',
            'title' => 'Booked Package',
            'bookingType' => 'Type',
            'status' => 'Status',
            'c_year' => [
                'label' => 'Year',
                'format' => function ($value) {
                    return $value ? $value : '-';
                }
            ],
            'created_by' => [
                'label' => 'Created By',
                'format' => function ($value) {
                    return $value ? CrossHelper::username($value) : '-';
                }
            ],
            'created_at' => [
                'label' => 'Created',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '-';
                }
            ],
            'action' => [
                'label' => 'Action',
                'actions' => [
                    function ($data) {
                        return Html::a('<i class="fa fa-eye"></i>', ['booking-requests', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'View Details']);
                    },
                    function ($data) {
                        return Html::a('<i class="fa fa-money-check-dollar"></i>', ['make-payment', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'Pay Now']);
                    },
                    function ($data) {
                        return Html::a('<i class="fa fa-edit"></i>', ['place-booking', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'Update details']);
                    },
                    function ($data) {
                        return Html::a('<i class="fa fa-archive"></i>', ['archived-booking', 'id' => $data['id']],
                            [
                                'class' => 'btn btn-outline-danger btn-sm',
                                'title' => 'Archive account',
                                'data' => [
                                    'confirm' => 'Are you sure you want to Archive this item?',
                                    'method' => 'post'
                                ]
                            ]);
                    },
                ]
            ]
        ];


        return $col;
    }
}
