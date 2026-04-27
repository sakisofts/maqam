<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maqam_exes".
 *
 * @property int $id
 * @property string $thumbnail
 * @property string $videoLink
 * @property string $description
 * @property string $detail
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class MaqamExes extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'maqam_exes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['thumbnail', 'videoLink', 'description', 'detail'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['thumbnail', 'description', 'detail'], 'string', 'max' => 255],
            [['videoLink'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thumbnail' => 'Thumbnail',
            'videoLink' => 'Video Link',
            'description' => 'Description',
            'detail' => 'Detail',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
