<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_activationcode".
 *
 * @property integer $activationcode_id
 * @property string $code
 * @property integer $promotion_id
 * @property string $added_date
 *
 * @property Promotion $promotion
 * @property CustomerActivatation[] $CustomerActivatations
 */
class Activationcode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_activationcode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'promotion_id', 'added_date'], 'required'],
            [['promotion_id'], 'integer'],
            [['added_date'], 'safe'],
            [['code'], 'string', 'max' => 255],
            [['promotion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promotion::className(), 'targetAttribute' => ['promotion_id' => 'promotion_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activationcode_id' => 'Activationcode ID',
            'code' => 'Code',
            'promotion_id' => 'Promotion ID',
            'added_date' => 'Added Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotion()
    {
        return $this->hasOne(Promotion::className(), ['promotion_id' => 'promotion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerActivatations()
    {
        return $this->hasMany(CustomerActivatation::className(), ['activation_id' => 'activationcode_id']);
    }
}
