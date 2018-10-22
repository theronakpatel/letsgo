<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MerchPromotion;

/**
 * MerchPromotionSearch represents the model behind the search form about `backend\models\MerchPromotion`.
 */
class MerchPromotionSearch extends MerchPromotion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mer_promotion_id'], 'integer'],
            [['name', 'description', 'image', 'merchant_code'], 'safe'],
            [['promotion_points'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MerchPromotion::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'mer_promotion_id' => $this->mer_promotion_id,
            'promotion_points' => $this->promotion_points,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'merchant_code', $this->merchant_code]);

        return $dataProvider;
    }
}
