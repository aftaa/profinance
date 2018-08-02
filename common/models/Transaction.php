<?php

namespace common\models;

use Yii;
use yii\validators\EmailValidator;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id № транзакции
 * @property string $email E-mail
 * @property string $phone Телефон
 * @property string $amount Сумма
 * @property string $currency Валюта
 * @property string $created_at Дата и время операции
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'currency', 'created_at'], 'required'],
            [['email', 'phone', 'currency'], 'trim'],
            [['amount'], 'number'],
            [['created_at'], 'safe'],
            [['email', 'phone'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№ транзакции',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'amount' => 'Сумма',
            'currency' => 'Валюта',
            'created_at' => 'Дата и время операции',
        ];
    }

    /**
     * @param string $emailOrPhone
     */
    public function setEmailOrPhone($emailOrPhone)
    {
        if ((new EmailValidator)->validate($emailOrPhone)) {
            $this->email = $emailOrPhone;
        } else {
            $this->phone = $emailOrPhone;
        }
    }

    /**
     * @param string $emailOrPhone
     * @param float $amount
     * @param string $currency
     * @return Transaction|null
     */
    public static function createTransaction($emailOrPhone, $amount, $currency)
    {
        if (!is_numeric($amount)) {
            return null;
        }
        $transaction = new self;
        $transaction->amount = $amount;
        $transaction->currency = $currency;
        $transaction->setEmailOrPhone($emailOrPhone);
        $transaction->created_at = (new \DateTime('now'))->format('Y-m-d H:i:s');
        if (!$transaction->save()) {
            throw new Exception($transaction->getFirstError());
        }
        return $transaction;
    }
}
