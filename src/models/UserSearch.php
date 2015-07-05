<?php

namespace johnitvn\advanceuser\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use johnitvn\advanceuser\models\User;

/**
 * UserSearch represents the model behind the search form about `johnitvn\advanceuser\models\User`.
 * @author John Martin <dmeroff@gmail.com>
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','creator', 'creator_ip', 'confirmed_at', 'status', 'created_at', 'updated_at'], 'integer'],
            [['email', 'password'], 'safe'],
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'creator'=> $this->creator,
            'creator_ip' => $this->creator_ip,
            'confirmed_at' => $this->confirmed_at,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}