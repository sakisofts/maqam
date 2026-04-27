<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reservation_pilgrim".
 *
 * @property int $id
 * @property int $reservation_id
 * @property int $pilgrim_id
 * @property int $created_at
 * @property int $updated_at
 */
class ReservationPilgrim extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservation_pilgrim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reservation_id', 'pilgrim_id', 'created_at', 'updated_at'], 'required'],
            [['reservation_id', 'pilgrim_id', 'created_at', 'updated_at'], 'integer'],
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
            'pilgrim_id' => 'Pilgrim ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
