<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_customer".
 *
 * @property integer $customer_id
 * @property resource $name
 * @property string $email
 * @property string $password
 * @property string $password_reset_token
 * @property integer $country_id
 * @property string $device_type
 * @property string $device_token
 * @property string $register_date
 *
 * @property Countries $country
 * @property CustomerActivatation[] $CustomerActivatations
 */
class Customer extends \yii\db\ActiveRecord
{
    public $message;
    public $device;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'message','device'], 'required', 'on' => 'notification'],
            [[ 'message'], 'string', 'max' => 150],
            [['name', 'email', 'password', 'password_reset_token', 'country_id', 'device_token', 'register_date'], 'safe'],
            [['name', 'device_type', 'device_token','referral_code'], 'string'],
            [[ 'country_id'], 'integer'],
            [['register_date','promotion_points'], 'safe'],
            [['email', 'password', 'password_reset_token'], 'string', 'max' => 255],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['country_id' => 'country_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'country_id' => 'Country ID',
            'device_type' => 'Device Type',
            'device_token' => 'Device Token',
            'register_date' => 'Register Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['country_id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerActivatations()
    {
        return $this->hasMany(CustomerActivatation::className(), ['customer_id' => 'customer_id']);
    }
}
