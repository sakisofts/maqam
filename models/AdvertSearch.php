<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Html;

class AdvertSearch extends Adverts implements SearchInterface
{

    public function rules() : array{
        return [
            [[ 'title', 'description',  'id'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return parent::scenarios();
    }

    public function search($params=null)
    {
        Yii::$app->session->remove("data");
        $query = (new Query())->select(['*'])->from('adverts');
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

        if (!empty($params['AdvertSearch'])) {
            // Fix the column references in the where conditions

            $query->andFilterWhere([
                'LOWER(description)' => strtolower($this->description),
                'LOWER(title)' => strtolower($this->title),
            ]);

        }

        Yii::$app->session->set("data", $dataProvider->getModels());


        return $dataProvider;
    }

    public function searchFields($params=null)
    {
        return [
            'title' => [
                'type' => 'text',
                'placeholder' => 'Search by title',
                'name' => 'title',
            ],
        ];
    }

    public function getData()
    {
        return yii::$app->session->get("data") ??  (new Query())->select(['*'])->from('adverts')->all();
    }

    public function ExportColumns()
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => [
                'label' => 'Date Created',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }],
            'endDateTime' => [
                'label' => 'Closing date',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }]
        ];
    }

    public function tableColumns()
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => [
                'label' => 'Date Created',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }],
            'endDateTime'  => [
                'label' => 'Closing date',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }],

            'action' => [
                'label' => 'Action',
                'actions' => [
                    function ($data) {
                        return Html::a('<i class="fa fa-edit"></i>', ['create', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'Update details']);
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
