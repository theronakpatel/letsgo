<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Posts;

/**
 * PostsSearch represents the model behind the search form about `backend\models\Posts`.
 */
class PostsSearch extends Posts
{
    /**
     * @inheritdoc
     */
    public $category_name;
    public function rules()
    {
        return [
            [['post_id', 'category_id'], 'integer'],
            [['name', 'description','category_name', 'address', 'image', 'added_date'], 'safe'],
            [['latitude', 'longitude'], 'number'],
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
        $query = Posts::find()
        ->select(['tbl_posts.*', 'tbl_category.name as category_name', 'tbl_posts.name as name'])
        ->join('INNER JOIN', 'tbl_category', 'tbl_category.category_id =tbl_posts.category_id');

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
            'post_id' => $this->post_id,
            'category_id' => $this->category_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'added_date' => $this->added_date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'tbl_category.name', $this->category_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
