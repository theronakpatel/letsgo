<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_customer_merch_activatation".
 *
 * @property integer $cust_act_id
 * @property integer $customer_id
 * @property integer $mer_promotion_id
 * @property string $merchant_code
 * @property double $points
 * @property string $activation_date
 */
class CustomerMerchActivatation extends \yii\db\ActiveRecord
{

    public $promotion_name;
    public $name;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_customer_merch_activatation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'mer_promotion_id', 'merchant_code', 'points', 'activation_date','name','promotion_name'], 'required'],
            [['customer_id', 'mer_promotion_id'], 'integer'],
            [['points'], 'number'],
            [['activation_date'], 'safe'],
            [['merchant_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cust_act_id' => 'Cust Act ID',
            'customer_id' => 'Customer ID',
            'mer_promotion_id' => 'Mer Promotion ID',
            'merchant_code' => 'Activation Code',
            'points' => 'Points',
            'activation_date' => 'Activation Date',
        ];
    }
}
