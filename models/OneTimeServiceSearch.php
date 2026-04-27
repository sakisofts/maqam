<?php

namespace app\models;

use app\components\Generics\CrossHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Html;

class OneTimeServiceSearch extends OneTimeServices implements SearchInterface
{


    public function rules(): array
    {
        return [
            [['create_at', 'total_charge', 'services', 'client_id', 'status', 'created_by', 'id'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return parent::scenarios();

    }

    public function search($params)
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
                ]
            ]
        ]);
        if ($params) {
            $this->load($params);
        }
        if (!$this->validate()) {
            return $dataProvider;
        }
        if (!empty($params['OneTimeServiceSearch'])) {
            $query->andFilterWhere(['client_id' => $this->client_id]);
            $query->andFilterWhere(['LOWER(services)' => strtolower($this->services)]);
        }
        Yii::$app->session->set("data", $dataProvider->getModels());
        return $dataProvider;
    }

    public function ql()
    {
        return (new Query())->select(['*'])->from('oneTimeServices');
    }

    public function searchFields()
    {
        return [
            'client_id' => [
                'type' => 'text',
                'placeholder' => 'Search by client',
                'name' => 'client_id',
            ],
            'status' => [
                'type' => 'select',
                'placeholder' => 'Search by status',
                'options' => OneTimeServices::optsStatus(),
                'name' => 'status',
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
            'client_id' => [
                'label' => 'Client',
                'format' => function ($d) {
                    return ucfirst(Users::findOne($d)->name);
                },
            ],
            'status' => [
                'label' => 'Status',
                'format' => function ($d) {
                    return $d;
                }
            ],
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
            'client_id' => [
                'label' => 'Customer',
                'format' => function ($d) {
                    return ucfirst(Users::findOne($d)->name);
                },
            ],
            'status' => [
                'label' => 'Status',
                'format' => function ($d) {
                    return $d;
                }
            ],
            'total_charge' => [
                'label' => 'Charge',
                'format' => function ($d) {
                    return Yii::$app->formatter->asCurrency($d, 'USD');
                }
            ],
            'created_at' => [
                'label' => 'Date Created',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }
            ]
            , 'action' => [
                'label' => 'Action',
                'actions' => [
                    function ($data) {
                        return Html::a('<i class="fa fa-edit"></i>', ['ots-create', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'Update details']);
                    },
                    function ($data) {
                        return Html::a('<i class="fa fa-money-bill-alt"></i>', ['pay-now', 'id' => $data['id'], 'type' => 'ots'],
                            [
                                'class' => 'btn btn-outline-primary btn-sm',
                                'title' => 'Make Payment',
                            ]);
                    }, function ($data) {
                        return Html::a('<i class="fa fa-print"></i>', ['export/receipt', 'id' => $data['id'],'t'=>'ots'],
                            [
                                'class' => 'btn btn-outline-primary btn-sm',
                                'title' => 'Print receipt',
                            ]);
                    }
                ]]
        ];
    }
}
