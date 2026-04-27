<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_roles".
 *
 * @property int $id
 * @property string $Role
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class UserRoles extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['Role'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['Role'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Role' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
