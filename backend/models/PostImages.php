<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_post_images".
 *
 * @property integer $post_image_id
 * @property integer $post_id
 * @property string $image
 * @property string $added_date
 */
class PostImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_post_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'image', 'added_date'], 'required'],
            [['post_id'], 'integer'],
            [['added_date'], 'safe'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_image_id' => 'Post Image ID',
            'post_id' => 'Post ID',
            'image' => 'Image',
            'added_date' => 'Added Date',
        ];
    }
}
