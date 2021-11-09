<?php

namespace app\modules\PhoneBook\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\PhoneBook\models\User;

/**
 * UserSearch represents the model behind the search form of `app\modules\PhoneBook\models\User`.
 */
class UserSearch extends User
{
    /**
     * @var string
     */
    public string $searchPhone = '';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['first_name', 'last_name', 'email', 'date_of_birth', 'searchPhone'], 'safe'],
        ];
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
        $query = User::find();
        $query->joinWith('userPhones');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->getSort()->attributes['searchPhone'] = [
            'asc' => ['user_phone.phone' => SORT_ASC],
            'desc' => ['user_phone.phone' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date_of_birth' => $this->date_of_birth,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'user_phone.phone', $this->searchPhone]);

        return $dataProvider;
    }
}
