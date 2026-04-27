<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "adverts".
 *
 * @property int $id
 * @property string $image
 * @property string $title
 * @property string $description
 * @property string $endDateTime
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Adverts extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adverts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['image', 'title', 'description', 'endDateTime'], 'required'],
            [['endDateTime', 'created_at', 'updated_at'], 'safe'],
            [['image', 'title', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'title' => 'Title',
            'description' => 'Description',
            'endDateTime' => 'End Date Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
