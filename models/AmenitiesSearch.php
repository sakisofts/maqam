<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Html;

class AmenitiesSearch extends Amenities implements SearchInterface
{
    public function rules(): array
    {
        return [
            [['amenity', 'created_by', 'created_at', 'charges', 'id'], 'safe'],
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
                    'id',
                ]
            ]
        ]);
        if ($params) {
            $this->load($params);
        }
        if (!$this->validate()) {
            return $dataProvider;
        }
        if (!empty($params['AmenitiesSearch'])) {
            $query->andFilterWhere(['like', 'amenity', $this->amenity]);
            $query->andFilterWhere(['like', 'charges', $this->charges]);
        }
        Yii::$app->session->set("data", $dataProvider->getModels());
        return $dataProvider;
    }

    public function ql()
    {
        return (new Query())->select(['*'])->from('amenities');
    }

    public function searchFields()
    {
        return [
            'amenity' => [
                'type' => 'text',
                'placeholder' => 'Search by amenity',
                'name' => 'amenity',
            ],
            'charges' => [
                'type' => 'text',
                'placeholder' => 'Search by charges',
                'name' => 'charges',
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
            'amenity' => 'Amenity',
            'charges' => [
                'label' => 'Charges',
                'format' => function ($value) {
                    return Yii::$app->formatter->asCurrency($value, 'USD');
                }
            ],
            'created_at' => [
                'label' => 'Created At',
                'format' => function ($value) {
                    return Yii::$app->formatter->asDate($value);
                }
            ]
        ];
    }

    public function tableColumns()
    {
        return [
            'amenity' => 'Amenity',
            'charges' => [
                'label' => 'Charges',
                'format' => function ($value) {
                    return Yii::$app->formatter->asCurrency($value, 'USD');
                }
            ],
            'created_at' => [
                'label' => 'Created At',
                'format' => function ($value) {
                    return Yii::$app->formatter->asDate($value);
                }
            ],
            'action' => [
                'label' => 'Action',
                'actions' => [
                    function ($data) {
                        return Html::a('<i class="fa fa-edit"></i>', ['amenity', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'Adjust charges']);
                    },
                    function ($data) {
                        return Html::a('<i class="fa fa-trash"></i>', ['drop-amenity', 'id' => $data['id']], ['class' => 'btn btn-outline-danger btn-sm', 'title' => 'Drop Item']);
                    },
                ]
            ]
        ];
    }
}
