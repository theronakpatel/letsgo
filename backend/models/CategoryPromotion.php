<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\Posts;
use backend\models\Category;

/**
 * This is the model class for table "tbl_category_promotion".
 *
 * @property integer $category_promo_id
 * @property integer $category_id
 * @property integer $promotion_id
 * @property string $added_date
 *
 * @property Posts $post
 * @property Promotion $promotion
 */
class CategoryPromotion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_category_promotion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'promotion_id', 'added_date'], 'required'],
            [['category_id', 'promotion_id'], 'integer'],
            [['added_date'], 'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'category_id']],
            [['promotion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promotion::className(), 'targetAttribute' => ['promotion_id' => 'promotion_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_promo_id' => 'Post Promo ID',
            'category_id' => 'Post ID',
            'promotion_id' => 'Promotion ID',
            'added_date' => 'Added Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
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
    public function PostDropdown()
    {
        $postlist = Posts::find()->asArray()->all();
        return  ArrayHelper::map($postlist, 'category_id', 'name');
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
