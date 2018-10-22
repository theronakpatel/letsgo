<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_customer_referral".
 *
 * @property integer $referral_id
 * @property integer $customer_id
 * @property integer $ref_customer_id
 * @property string $date
 */
class CustomerReferral extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_customer_referral';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'ref_customer_id', 'date'], 'required'],
            [['customer_id', 'ref_customer_id'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'referral_id' => 'Referral ID',
            'customer_id' => 'Customer ID',
            'ref_customer_id' => 'Ref Customer ID',
            'date' => 'Date',
        ];
    }
}
