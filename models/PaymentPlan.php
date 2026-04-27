<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_plan".
 *
 * @property int $id
 * @property int $reservation_id
 * @property int $total_installments
 * @property int $created_at
 * @property int $updated_at
 */
class PaymentPlan extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reservation_id', 'total_installments', 'created_at', 'updated_at'], 'required'],
            [['reservation_id', 'total_installments', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reservation_id' => 'Reservation ID',
            'total_installments' => 'Total Installments',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
