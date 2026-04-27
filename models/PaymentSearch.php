<?php

namespace app\models;


use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Html;

class PaymentSearch extends Payment implements SearchInterface
{

    public function rules(): array
    {

        return [
            [['id', 'payment_number', 'reservation_id','rate','from_currency','to_currency','conversional_rate', 'amount', 'payment_method', 'payment_status', 'payment_date', 'updated_at'], 'safe'],
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
                    'id' => SORT_DESC,
                ],
                'attributes' => [
                    'id'
                ]
            ]]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        if ($params) {
            $query->andFilterWhere(['id' => $this->id]);
            $query->andFilterWhere(['payment_number' => $this->payment_number]);
            $query->andFilterWhere(['reservation_id' => $this->reservation_id]);
            $query->andFilterWhere(['amount' => $this->amount]);
            $query->andFilterWhere(['payment_method' => $this->payment_method]);
            $query->andFilterWhere(['payment_status' => $this->payment_status]);
            $query->andFilterWhere(['payment_date' => $this->payment_date]);
            $query->andFilterWhere(['updated_at' => $this->updated_at]);
        }
        Yii::$app->session->set("data", $dataProvider->getModels());
        return $dataProvider;


    }

    public function ql()
    {
        return (new Query())->select(['*'])->from('payment');
    }

    public function searchFields()
    {
        return [
            'payment_number' => [
                'type' => 'text',
                'placeholder' => 'Search by payment number',
                'name' => 'payment_number',
            ],
            'reservation_id' => [
                'type' => 'text',
                'placeholder' => 'Search by reservation id',
                'name' => 'reservation_id',
            ]
        ];
    }

    public function getData()
    {
        return Yii::$app->session->get("data") ?? $this->ql()->all();;
    }

    public function ExportColumns()
    {
        return [
            'payment_number' => 'Reservation Number',
            'amount' => [
                'label' => 'Amount',
                'format' => function ($model) {
                    return $model ? Yii::$app->formatter->asCurrency($model, 'USD') : '-';
                }
            ],
            'payment_method' => 'Payment Method',
            'payment_status' => 'Payment Status',
            'payment_date' => [
                'label' => 'Payment Date',
                'format' => function ($model) {
                    return $model ? Yii::$app->formatter->asDate($model) : '-';
                }
            ],
        ];
    }

    public function tableColumns()
    {
        return [
            'payment_number' => 'Reservation Number',
            'to_currency'=>[
              'label' => 'Currency',
                'format' => function ($model) {
                    return $model ? $model : 'USD';
                }
            ],
            'rate'=>[
                'label' => 'Rate',
                'format' => function ($model) {
                    return $model ? $model : '3700';
                }
            ],
            'amount' => [
                'label' => 'Amount Paid',
                'format' => function ($model) {
                    return $model ? Yii::$app->formatter->asCurrency($model, 'USD') : '-';
                }
            ],
            'payment_method' => 'Method',
            'payment_status' => 'Status',
            'payment_date' => [
                'label' => 'Txn Date',
                'format' => function ($model) {
                    return $model ? Yii::$app->formatter->asDate($model) : '-';
                }
            ],
            'action' => [
                'label' => 'Action',
                'actions' => [function ($data) {
                    return Html::a('<i class="fa fa-print"></i>', ['export/receipt', 'id' => $data['id'], 't' => 'prf'], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'Print Payment proof']);
                },
                ]
            ]
        ];
    }


}
