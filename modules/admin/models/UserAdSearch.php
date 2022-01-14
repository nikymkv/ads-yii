<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserAd;

/**
 * UserAdSearch represents the model behind the search form of `app\models\UserAd`.
 */
class UserAdSearch extends UserAd
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'category_id', 'subcategory_id', 'currency_id', 'location_id', 'city_id', 'bargain', 'status'], 'integer'],
            [['title', 'slug', 'description', 'photo_array', 'phone_array', 'created_at'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = UserAd::find();

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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'currency_id' => $this->currency_id,
            'location_id' => $this->location_id,
            'city_id' => $this->city_id,
            'price' => $this->price,
            'bargain' => $this->bargain,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'photo_array', $this->photo_array])
            ->andFilterWhere(['like', 'phone_array', $this->phone_array]);

        return $dataProvider;
    }
}
