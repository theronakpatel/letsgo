<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_post_promotion".
 *
 * @property integer $post_promo_id
 * @property integer $post_id
 * @property integer $promotion_id
 * @property string $added_date
 *
 * @property Posts $post
 * @property Promotion $promotion
 */
class PostPromotion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_post_promotion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'promotion_id', 'added_date'], 'required'],
            [['post_id', 'promotion_id'], 'integer'],
            [['added_date'], 'safe'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_id' => 'post_id']],
            [['promotion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promotion::className(), 'targetAttribute' => ['promotion_id' => 'promotion_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_promo_id' => 'Post Promo ID',
            'post_id' => 'Post ID',
            'promotion_id' => 'Promotion ID',
            'added_date' => 'Added Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['post_id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotion()
    {
        return $this->hasOne(Promotion::className(), ['promotion_id' => 'promotion_id']);
    }
}
