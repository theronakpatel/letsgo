<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 * Category Model
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class Category extends ActiveRecord
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
    public static function primaryKey()
    {
        return ['category_id'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['category_id', 'name','icon'], 'safe']
        ];
    }
}
