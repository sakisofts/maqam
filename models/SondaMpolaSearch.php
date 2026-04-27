<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Html;

class SondaMpolaSearch extends SondaMpolas implements SearchInterface
{
    public function rules() : array{
        return [
            [['name', 'email','phone', 'savingFor','targetAmount','reference','processing_status','created_by','id'], 'safe'],
        ];

    }
    public function scenarios()
    {
        return parent::scenarios();
    }

    public function ql(){
        return (new Query())->select(['sm.*','u.name as createdBy'])->from('sonda_mpolas sm')
            ->innerJoin('users u', 'sm.created_by = u.id');
    }

    public function search($params=null): ActiveDataProvider
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
                    'id',
                    'name',
                    'email',
                    'phone',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        if ($params) {
            $this->load($params);
        }

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($params['BookingSearch'])) {
            // Fix the column references in the where conditions

            $query->andFilterWhere([
                'b.name' => $this->name,
                'b.email' => $this->email,
            ]);

//            $query->andFilterWhere(['like', 'LOWER(u.name)', strtolower($this->name)])
//                ->andFilterWhere(['like', 'p.category', $this->category]);
        }

        Yii::$app->session->set("data", $dataProvider->getModels());


        return $dataProvider;

    }

    public function searchFields()
    {
        return [
            [
                'name' => 'name',
                'type' => 'text',
                'placeholder' => 'Search by Name',
            ],
            [
                'name' => 'email',
                'type' => 'text',
                'placeholder' => 'Search by Email',
            ],
            [
                'name' => 'phone',
                'type' => 'text',
                'placeholder' => 'Search by Phone',
            ],
            [
                'name' => 'created_at',
                'type' => 'date',
                'placeholder' => 'Search by date created',
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
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'created_at' => [
                'label' => 'Date Created',
                 'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                 }]
            ];
    }

    public function tableColumns()
    {
        return [
            'name' => 'Name',
            'phone' => 'Mobile',
            'savingFor' => 'Account Purpose',
            'targetAmount' => [
                'label' => 'Target Amount',
                'format' => function ($value) {
                    return $value ? 'UGX ' .number_format($value) : '';
                }
            ],
            'created_at' => [
                'label' => 'Date Created',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }
            ],
            'createdBy' => 'Created By',
            'action' => [
                'label' => 'Action',
                'actions' => [
                    function ($data) {
                        return Html::a('<i class="fa fa-eye"></i>', ['sonda-account', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'View Details']);
                    },
                    function ($data) {
                        return Html::a('<i class="fa fa-edit"></i>', ['update-sonda-account', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'Update details']);
                    },
                    function ($data) {
                        return Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $data['id']],
                            [
                                'class' => 'btn btn-outline-danger btn-sm',
                                'title' => 'Drop account',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post'
                                ]
                            ]);
                    },
                ]
            ]

        ];
    }


}
