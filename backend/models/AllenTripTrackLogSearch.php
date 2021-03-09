<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AllenTripTrackLog;

/**
 * AllenTripTrackLogSearch represents the model behind the search form of `backend\models\AllenTripTrackLog`.
 */
class AllenTripTrackLogSearch extends AllenTripTrackLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'enter_starting_km', 'enter_close_km'], 'integer'],
            [['trip_track_id', 'trip_id', 'customer_id', 'trip_start_time', 'trip_end_time', 'start_trip', 'close_trip', 'expenses_1', 'expenses_2', 'expenses_3', 'digital_signature', 'status', 'trip_status', 'created_at', 'modified_at', 'updated_ipaddress', 'device_name', 'driver_name', 'vehicle_number'], 'safe'],
            [['expenses_1_amt', 'expenses_2_amt', 'expenses_3_amt'], 'number'],
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
        $query = AllenTripTrackLog::find();

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
            'trip_start_time' => $this->trip_start_time,
            'trip_end_time' => $this->trip_end_time,
            'enter_starting_km' => $this->enter_starting_km,
            'enter_close_km' => $this->enter_close_km,
            'expenses_1_amt' => $this->expenses_1_amt,
            'expenses_2_amt' => $this->expenses_2_amt,
            'expenses_3_amt' => $this->expenses_3_amt,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'trip_track_id', $this->trip_track_id])
            ->andFilterWhere(['like', 'trip_id', $this->trip_id])
            ->andFilterWhere(['like', 'customer_id', $this->customer_id])
            ->andFilterWhere(['like', 'start_trip', $this->start_trip])
            ->andFilterWhere(['like', 'close_trip', $this->close_trip])
            ->andFilterWhere(['like', 'expenses_1', $this->expenses_1])
            ->andFilterWhere(['like', 'expenses_2', $this->expenses_2])
            ->andFilterWhere(['like', 'expenses_3', $this->expenses_3])
            ->andFilterWhere(['like', 'digital_signature', $this->digital_signature])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'trip_status', $this->trip_status])
            ->andFilterWhere(['like', 'updated_ipaddress', $this->updated_ipaddress])
            ->andFilterWhere(['like', 'device_name', $this->device_name])
            ->andFilterWhere(['like', 'driver_name', $this->driver_name])
            ->andFilterWhere(['like', 'vehicle_number', $this->vehicle_number]);

        return $dataProvider;
    }
}
