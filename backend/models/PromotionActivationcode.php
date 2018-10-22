<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_promotion_activationcode".
 *
 * @property integer $pa_id
 * @property integer $promotion_id
 * @property integer $activation_code
 *
 * @property Promotion $promotion
 */
class PromotionActivationcode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_promotion_activationcode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['promotion_id', 'activation_code'], 'required'],
            [['promotion_id'], 'integer'],
            // [['activation_code'], 'exist'],
            [['activation_code'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pa_id' => 'Pa ID',
            'promotion_id' => 'Promotion ID',
            'activation_code' => 'Activation code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotion()
    {
        return $this->hasOne(Promotion::className(), ['promotion_id' => 'promotion_id']);
    }
 
}
