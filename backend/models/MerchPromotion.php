<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_merch_promotion".
 *
 * @property integer $mer_promotion_id
 * @property resource $name
 * @property resource $description
 * @property string $image
 * @property double $promotion_points
 * @property string $merchant_code
 */
class MerchPromotion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_merch_promotion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description','merchant_code','promotion_points'], 'required'],
            [['name', 'description','merchant_code'], 'string'],
            [['merchant_code'], 'string', 'max' => 6],
            [['promotion_points'], 'number', 'min' => 0, 'max' => 1000],
            [['image'], 'required', 'on'=>'create'],
            [['image'],'file','skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg','maxSize' => 1024 * 1024 * 5,],
            [['image'], 'file','skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg','maxSize' => 1024 * 1024 * 5 ,'on'=>'update'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mer_promotion_id' => 'Mer Promotion ID',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Image',
            'promotion_points' => 'Price',
            'merchant_code' => 'Merchant Code',
        ];
    }
}
