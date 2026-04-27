<?php

namespace app\models;

use http\Params;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Html;

class PackageSearch extends Packages implements SearchInterface
{

    public function rules() : array{
        return [
            [['type', 'title', 'description','is_archived', 'price', 'id'], 'safe'],
        ];
    }

    public function scenarios(){
        return parent::scenarios();
    }

    public function ql(){
        return (new Query())->select(['*'])->from('packages');
    }

    public function search($params=null)
    {
        Yii::$app->session->remove("data");
        $query = $this->ql();
        if(!$params){
            $query->where(['is_archived'=>0]);
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
                    'id',
                ],
            ],
        ]);

        if ($params) {
            $this->load($params);
        }

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($params['PackageSearch'])) {
            $query->andFilterWhere([
                'LOWER(category)' =>strtolower($this->category)]);
            $query->andFilterWhere(['LOWER(title)' => strtolower($this->title)]);
            $query->andFilterWhere(['is_archived'=>$this->is_archived]);

        }

        Yii::$app->session->set("data", $dataProvider->getModels());
        return $dataProvider;
    }

    public function searchFields($params=null)
    {
        return [
            'title' => [
                'type' => 'text',
                'placeholder' => 'Search by package Title',
                'name' => 'title',
            ],
            'category' => [
                'type' => 'email',
                'placeholder' => 'Search by Category',
                'name' => 'category',
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
    }

    public function getData()
    {
        return yii::$app->session->get("data") ?? $this->ql()->all();
    }

    public function ExportColumns()
    {
        return [
            'category' => 'Category',
            'type' => 'Type',
            'standardPrice' => 'Standard Price',
            'economyPrice' => 'Economy Price',
            'title' => 'Title',
            'dateRange' => 'Date Range',
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
            'title' => 'Title',
            'category' => 'Category',
//            'type' => 'Type',
            'standardPrice' => [
                'label' => 'Price',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asCurrency($value, 'USD') : '-';
                }
            ],
            'dateRange' => 'Date Range',
            'created_at' => [
                'label' => 'Date Created',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }]
            ,'action' => [
                'label' => 'Action',
                'actions' => [
                    function ($data) {
                        return Html::a('<i class="fa fa-edit"></i>', ['create', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'Update details']);
                    },
                    function ($data) {
                        return Html::a('<i class="fa fa-archive"></i>', ['archive', 'id' => $data['id']],
                            [
                                'class' => 'btn btn-outline-danger btn-sm',
                                'title' => 'Archive account',
                                'data' => [
                                    'confirm' => 'Are you sure you want to archive this item?',
                                    'method' => 'post'
                                ]
                            ]);
                    },
                ]
            ]
        ];
    }
}
