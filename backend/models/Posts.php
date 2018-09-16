<?php

namespace backend\models;

use backend\models\Category;
use Yii;

/**
 * This is the model class for table "tbl_posts".
 *
 * @property integer $post_id
 * @property integer $category_id
 * @property resource $name
 * @property resource $description
 * @property resource $address
 * @property double $latitude
 * @property double $longitude
 * @property string $image
 * @property string $added_date
 *
 * @property PostPromotion[] $PostPromotions
 * @property Category $category
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $category_name;
    
    public static function tableName()
    {
        return 'tbl_posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id','name', 'description', 'address', 'latitude', 'longitude'], 'required'],
            [['image'], 'required', 'on'=>'create'],
            [['category_id'], 'integer'],
            [['name', 'description', 'address'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['added_date','category_name'], 'safe'],
            [['image'],'file','skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg','maxSize' => 1024 * 1024 * 5,],
            [['image'], 'file','skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg','maxSize' => 1024 * 1024 * 5 ,'on'=>'update'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post',
            'category_id' => 'Category',
            'name' => 'Name',
            'description' => 'Description',
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'image' => 'Image',
            'added_date' => 'Added Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostPromotions()
    {
        return $this->hasMany(PostPromotion::className(), ['post_id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }
}
