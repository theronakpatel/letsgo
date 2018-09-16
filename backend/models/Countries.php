<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_countries".
 *
 * @property integer $country_id
 * @property string $name
 *
 * @property Customer[] $tblCustomers
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'name','shortcode'], 'required'],
            [['name','shortcode'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_id' => 'Country ID',
            'name' => 'Name',
            'shortcode' => 'Short Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['country_id' => 'country_id']);
    }
}
