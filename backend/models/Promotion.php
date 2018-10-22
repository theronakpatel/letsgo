<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_promotion".
 *
 * @property integer $promotion_id
 * @property resource $name
 * @property resource $description
 * @property string $image
 *
 * @property Activationcode[] $Activationcodes
 * @property CategoryPromotion[] $CategoryPromotions
 * @property PostPromotion[] $PostPromotions
 */
class Promotion extends \yii\db\ActiveRecord
{
    public $posts;
    public $categories;
    public $total_activationcodes;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_promotion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description','promotion_points'], 'required'],
            [['name', 'description','merchant_code'], 'string'],
            [['merchant_code'], 'string', 'max' => 6],
            // [['merchant_code'],'unique'],
            [['promotion_points'], 'number', 'min' => 0, 'max' => 1000],
            [['total_activationcodes'], 'number', 'min' => 1, 'max' => 100],
            [['posts', 'categories','total_activationcodes'], 'safe'],
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
            'promotion_id' => 'Promotion ID',
            'name' => 'Name',
            'merchant_code' => 'Merchant Activation Code',
            'description' => 'Description',
            'image' => 'Image',
            'total_activationcodes' => 'Total no. of Activation codes to generate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivationcodes()
    {
        return $this->hasMany(Activationcode::className(), ['promotion_id' => 'promotion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryPromotions()
    {
        return $this->hasMany(CategoryPromotion::className(), ['promotion_id' => 'promotion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostPromotions()
    {
        return $this->hasMany(PostPromotion::className(), ['promotion_id' => 'promotion_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function PostDropdown()
    {
        $postlist = Posts::find()->asArray()->all();
        return  ArrayHelper::map($postlist, 'post_id', 'name');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function CategoryDropdown()
    {
        $categorylist = Category::find()->asArray()->all();
        return  ArrayHelper::map($categorylist, 'category_id', 'name');
    }
}
