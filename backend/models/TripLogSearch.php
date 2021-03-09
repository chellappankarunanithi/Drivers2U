<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TripLog;

/**
 * TripLogSearch represents the model behind the search form of `backend\models\TripLog`.
 */
class TripLogSearch extends TripLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['logId', 'tripId', 'customerId'], 'integer'],
            [['tripStatus', 'tripDetails', 'createdAt', 'updatedAt', 'updatedIpAddress'], 'safe'],
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
        $query = TripLog::find();

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
            'logId' => $this->logId,
            'tripId' => $this->tripId,
            'customerId' => $this->customerId,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'tripStatus', $this->tripStatus])
            ->andFilterWhere(['like', 'tripDetails', $this->tripDetails])
            ->andFilterWhere(['like', 'updatedIpAddress', $this->updatedIpAddress]);

        return $dataProvider;
    }
}
