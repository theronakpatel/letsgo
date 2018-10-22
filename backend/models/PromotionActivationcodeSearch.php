<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PromotionActivationcode;

/**
 * PromotionSearch represents the model behind the search form about `backend\models\PromotionActivationcode`.
 */
class PromotionActivationcodeSearch extends PromotionActivationcode
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['promotion_id', 'activation_code'], 'safe'],
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
    public function search($params,$id)
    {
        $query = PromotionActivationcode::find()->where(['promotion_id' => $id]);

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

        $query->andFilterWhere(['like', 'activation_code', $this->activation_code]);

        return $dataProvider;
    }
}
