<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CancelTripLog;

/**
 * CancelTripLogSearch represents the model behind the search form of `backend\models\CancelTripLog`.
 */
class CancelTripLogSearch extends CancelTripLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['TripId', 'CustomerId', 'DriverId', 'CancelReason', 'PaymentStatus', 'CreatedDate', 'UpdatedIpaddress', 'UpdatedDate'], 'safe'],
            [['CancelFees'], 'number'],
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
        $query = CancelTripLog::find();

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
            'CancelFees' => $this->CancelFees,
            'CreatedDate' => $this->CreatedDate,
            'UpdatedDate' => $this->UpdatedDate,
        ]);

        $query->andFilterWhere(['like', 'TripId', $this->TripId])
            ->andFilterWhere(['like', 'CustomerId', $this->CustomerId])
            ->andFilterWhere(['like', 'DriverId', $this->DriverId])
            ->andFilterWhere(['like', 'CancelReason', $this->CancelReason])
            ->andFilterWhere(['like', 'PaymentStatus', $this->PaymentStatus])
            ->andFilterWhere(['like', 'UpdatedIpaddress', $this->UpdatedIpaddress]);

        return $dataProvider;
    }
}
