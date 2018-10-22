<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_customer_activatation".
 *
 * @property integer $cust_act_id
 * @property integer $customer_id
 * @property integer $promotion_id
 * @property string $activation_code
 * @property string $activation_date
 * @property string $points
 * @property TblCustomer $customer
 * @property TblPromotion $promotion
 */
class CustomerActivatation extends \yii\db\ActiveRecord
{
    public $promotion_name;
    public $name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_customer_activatation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'promotion_id', 'activation_code', 'activation_date', 'name', 'promotion_name'], 'required'],
            [['customer_id', 'promotion_id'], 'integer'],
            [['activation_date','points'], 'safe'],
            [['activation_code'], 'string', 'max' => 255],
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
            'promotion_id' => 'Promotion ID',
            'activation_code' => 'Activation Code',
            'activation_date' => 'Activation Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(TblCustomer::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotion()
    {
        return $this->hasOne(TblPromotion::className(), ['promotion_id' => 'promotion_id']);
    }
}
