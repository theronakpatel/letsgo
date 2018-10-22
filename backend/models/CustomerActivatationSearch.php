<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CustomerActivatation;

/**
 * CustomerSearch represents the model behind the search form about `backend\models\CustomerActivatation`.
 */
class CustomerActivatationSearch extends CustomerActivatation
{
    public $promotion_name;
    public $name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'promotion_id', 'activation_code', 'activation_date', 'name', 'promotion_name'], 'safe'],
            [['customer_id', 'promotion_id'], 'integer'],
            [['activation_date','points'], 'safe'],
            [['activation_code'], 'string', 'max' => 255],
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
        $query = CustomerActivatation::find()
        ->select(['tbl_customer_activatation.*','tbl_customer.name','tbl_promotion.name as promotion_name'])
        ->join('INNER JOIN', 'tbl_customer', 'tbl_customer_activatation.customer_id =tbl_customer.customer_id')
        ->join('INNER JOIN', 'tbl_promotion', 'tbl_customer_activatation.promotion_id =tbl_promotion.promotion_id');
        

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
            'customer_id' => $this->customer_id,
            'promotion_id' => $this->promotion_id,
        ]);

        $query->andFilterWhere(['like', 'activation_code', $this->activation_code])
            ->andFilterWhere(['like', 'activation_date', $this->activation_date])
            ->andFilterWhere(['like', 'tbl_promotion.name', $this->promotion_name])
            ->andFilterWhere(['like', 'tbl_customer.name', $this->name])
            ->andFilterWhere(['like', 'points', $this->points]);

        return $dataProvider;
    }
}
