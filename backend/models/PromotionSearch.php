<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Promotion;

/**
 * PromotionSearch represents the model behind the search form about `backend\models\Promotion`.
 */
class PromotionSearch extends Promotion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['promotion_id'], 'integer'],
            [['name', 'description', 'image','promotion_points','merchant_code'], 'safe'],
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
        $query = Promotion::find();

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
            'promotion_id' => $this->promotion_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'merchant_code', $this->merchant_code])
            ->andFilterWhere(['=', 'promotion_points', $this->promotion_points])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
