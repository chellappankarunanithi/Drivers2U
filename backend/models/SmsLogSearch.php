<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SmsLog;

/**
 * SmsLogSearch represents the model behind the search form of `backend\models\SmsLog`.
 */
class SmsLogSearch extends SmsLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['logId', 'tripId', 'customerId', 'driverId'], 'integer'],
            [['event', 'messageContent', 'status', 'timestamp'], 'safe'],
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
        $query = SmsLog::find();

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
            'driverId' => $this->driverId,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'event', $this->event])
            ->andFilterWhere(['like', 'messageContent', $this->messageContent])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
