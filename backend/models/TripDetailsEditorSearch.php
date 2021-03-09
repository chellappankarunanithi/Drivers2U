<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TripDetails;

/**
 * TripDetailsSearch represents the model behind the search form of `backend\models\TripDetails`.
 */
class TripDetailsEditorSearch extends TripDetailsEditor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['trip_title', 'customer_name', 'trip_type', 'person_name', 'pickup_type', 'trip_date_time', 'flight_number', 'vehicle_number', 'driver_name', 'vehicle_type', 'remarks', 'created_at', 'updated_at', 'updated_ipaddress', 'user_id'], 'safe'],
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
        if(isset($_GET['TripDetailsSearch']['trip_current_status']) && ($_GET['TripDetailsSearch']['trip_current_status']!="")){
         $trip=$_GET['TripDetailsSearch']['trip_current_status'];
         if($trip!="C"){
            $query = TripDetails::find()->joinWith(['customer'])->where(['trip_current_status'=>$trip]);
         }else{
            $query = TripDetails::find()->joinWith(['customer'])->where(['IN','trip_current_status',array('C','F')]);
         }
        }else{
        $query = TripDetails::find()->joinWith(['customer'])->where(['trip_current_status'=>"D"]);
        }

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
            'trip_date_time' => $this->trip_date_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'trip_title', $this->trip_title])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'trip_type', $this->trip_type])
            ->andFilterWhere(['like', 'pickup_type', $this->pickup_type])
            ->andFilterWhere(['like', 'flight_number', $this->flight_number])
            ->andFilterWhere(['like', 'vehicle_number', $this->vehicle_number])
            ->andFilterWhere(['like', 'driver_name', $this->driver_name])
            ->andFilterWhere(['like', 'vehicle_type', $this->vehicle_type])
            ->andFilterWhere(['like', 'customer_details.company_name', $this->person_name])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'updated_ipaddress', $this->updated_ipaddress])
            ->andFilterWhere(['like', 'user_id', $this->user_id]);

        return $dataProvider;
    }
}
