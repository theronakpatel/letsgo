<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_category".
 *
 * @property integer $category_id
 * @property string $name
 * @property integer $icon
 * @property string $added_date
 *
 * @property CategoryPromotion[] $CategoryPromotions
 * @property Posts[] $Posts
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['icon'], 'required', 'on'=>'create'],
            [['icon'],'file','skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg','maxSize' => 1024 * 1024 * 5,],
            [['icon'], 'file','skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg','maxSize' => 1024 * 1024 * 5 ,'on'=>'update'],
            [['added_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'name' => 'Name',
            'icon' => 'Icon',
            'added_date' => 'Added Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryPromotions()
    {
        return $this->hasMany(CategoryPromotion::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::className(), ['category_id' => 'category_id']);
    }
}
