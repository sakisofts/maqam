<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property int $packageId
 * @property string|null $name
 * @property string|null $description
 * @property string|null $image
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Services extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'image', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['packageId'], 'required'],
            [['packageId'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'packageId' => 'Package ID',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
