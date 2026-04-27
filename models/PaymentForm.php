<?php
namespace app\models;
use Yii;
use yii\base\Model;

/**
 * PaymentForm is the model behind the payment form.
 */
class PaymentForm extends Model
{
    public $phone;
    public $amount;
    public $reference;
    public $description;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['phone', 'amount', 'reference'], 'required'],
            ['phone', 'match', 'pattern' => '/^[0-9]{10,12}$/', 'message' => 'Phone number must be 10-12 digits'],
//            ['amount', 'number', 'min' => 1],
            ['reference', 'string', 'min' => 3, 'max' => 50],
            ['description', 'string', 'max' => 255],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'phone' => 'Phone Number (with country code)',
            'amount' => 'Amount',
            'reference' => 'Reference',
            'description' => 'Description',
        ];
    }
}
