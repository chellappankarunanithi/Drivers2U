<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TripDetails;

/**
 * TripDetailsSearch represents the model behind the search form of `backend\models\TripDetails`.
 */
class TripDetailsSearch extends TripDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['tripcode', 'CustomerId', 'CustomerName', 'GuestName', 'GuestContact', 'CustomerContactNo', 'DriverName', 'DriverContactNo', 'DriverId', 'VehicleId', 'VehicleType', 'VehicleMade', 'VehicleNo', 'TripType', 'TripScheduleType', 'ChangeTrip', 'ChangeReason', 'TripStartLoc', 'TripEndLoc', 'StartDateTime', 'EndDateTime', 'Review', 'CommissionId', 'CommissionType', 'CreatedDate', 'UpdatedDate', 'UpdatedIpaddress','TripStatus'], 'safe'],
            [['TripCost', 'CommissionAmount'], 'number'],
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
    public function search($params,$key="")
    {

        // echo "<prE>";print_r($params);die;

        $query = TripDetails::find()->joinWith(['client','driver']);
        if ($key!="") {
            $query->where(['TripStatus'=>$key]);
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
            //'StartDateTime' => $this->StartDateTime,
            //'EndDateTime' => $this->EndDateTime,
           // 'TripCost' => $this->TripCost,
           // 'CommissionAmount' => $this->CommissionAmount,
            'CreatedDate' => $this->CreatedDate,
            'UpdatedDate' => $this->UpdatedDate,
        ]);

        $query->andFilterWhere(['like', 'tripcode', $this->tripcode])
            ->andFilterWhere(['like', 'CustomerId', $this->CustomerId])
            ->andFilterWhere(['like', 'DriverId', $this->DriverId])
            ->andFilterWhere(['like', 'VehicleId', $this->VehicleId])
            ->andFilterWhere(['like', 'VehicleType', $this->VehicleType])
            ->andFilterWhere(['like', 'VehicleMade', $this->VehicleMade])
            ->andFilterWhere(['like', 'VehicleNo', $this->VehicleNo])
            ->andFilterWhere(['like', 'TripType', $this->TripType])
            ->andFilterWhere(['like', 'TripScheduleType', $this->TripScheduleType])
            ->andFilterWhere(['like', 'ChangeTrip', $this->ChangeTrip])
            ->andFilterWhere(['like', 'ChangeReason', $this->ChangeReason])
            ->andFilterWhere(['like', 'TripStartLoc', $this->TripStartLoc])
            ->andFilterWhere(['like', 'TripEndLoc', $this->TripEndLoc])
            ->andFilterWhere(['like', 'GuestContact', $this->GuestContact])
            ->andFilterWhere(['like', 'GuestName', $this->GuestName])
            ->andFilterWhere(['like', 'Review', $this->Review])
            ->andFilterWhere(['like', 'CommissionId', $this->CommissionId])
            ->andFilterWhere(['like', 'CommissionType', $this->CommissionType])
            ->andFilterWhere(['like', 'client_master.company_name', $this->CustomerName]) 
            ->andFilterWhere(['like', 'client_master.mobile_no', $this->CustomerContactNo])
            ->andFilterWhere(['like', 'driver_profile.name', $this->DriverName])
            ->andFilterWhere(['like', 'driver_profile.mobile_number', $this->DriverContactNo])
            ->andFilterWhere(['like', 'StartDateTime', $this->StartDateTime])
            ->andFilterWhere(['like', 'EndDateTime', $this->EndDateTime])
            ->andFilterWhere(['like', 'TripCost', $this->TripCost])
            ->andFilterWhere(['like', 'CommissionAmount', $this->CommissionAmount])
            ->andFilterWhere(['like', 'TripStatus', $this->TripStatus])
            ->andFilterWhere(['like', 'UpdatedIpaddress', $this->UpdatedIpaddress]);

        return $dataProvider;
    }
}
