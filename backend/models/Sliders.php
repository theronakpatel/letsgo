<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_sliders".
 *
 * @property integer $slider_id
 * @property string $image
 * @property string $position
 * @property string $added_date
 */
class Sliders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_sliders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position'], 'required'],
            [['image'], 'required', 'on'=>'create'],
            [['image'],'file','skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg','maxSize' => 1024 * 1024 * 5,],
            [['image'], 'file','skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg','maxSize' => 1024 * 1024 * 5 ,'on'=>'update'],
            [['added_date'], 'safe'],
            [['position'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'slider_id' => 'Slider ID',
            'image' => 'Image',
            'position' => 'Position',
            'added_date' => 'Added Date',
        ];
    }
}
