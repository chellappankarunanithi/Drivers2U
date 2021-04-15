<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\VehicleMaster;
use yii\db\Query;
/**
 * VehicleMasterSearch represents the model behind the search form about `backend\models\VehicleMaster`.
 */
class VehicleMasterSearch extends VehicleMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['vehicle_name', 'vehicle_uniqe_name', 'clientname', 'superviser_id', 'bunkagencyname', 'drivername','vehiclename', 'supervisorname', 'driver_name', 'client_name', 'reg_no', 'status', 'bunk_name', 'updated_ipaddress', 'created_at', 'modified_at'], 'safe'],
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
    public function search($params,$id="")
    {       
            $query = VehicleMaster::find()->where(['client_id'=>$id])->orderBy(['id'=>SORT_DESC]);
       

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
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'vehicle_name', $this->vehicle_name])
            ->andFilterWhere(['like', 'vehicle_uniqe_name', $this->vehicle_uniqe_name])
            ->andFilterWhere(['like', 'reg_no', $this->reg_no])
            ->andFilterWhere(['like', 'vehicle_master.status', $this->status])
            ->andFilterWhere(['like', 'updated_ipaddress', $this->updated_ipaddress]);

        return $dataProvider;
    }


    public function reportsearch($params,$map="")
    {  
        if(empty($params['fromdate']) && empty($params['todate']) && empty($params['reg_no']) && 
        empty($params['superviser']) && empty($params['client']) && empty($params['coupon_status'])){
         
        $query = VehicleMaster::find()->where(['vehicle_master.status'=>'tt']);
        }else{
        if($_GET['fromdate']!="" && $_GET['todate']!=""){
             $fromdate = date('Y-m-d 00:00:00', strtotime($_GET['fromdate']));
             $todate = date('Y-m-d 23:59:59', strtotime($_GET['todate'])); 
        } 
        } 

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
            'vehicle_master.created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'vehicle_name', $this->vehicle_name])
            ->andFilterWhere(['like', 'vehicle_uniqe_name', $this->vehicle_uniqe_name])
            ->andFilterWhere(['like', 'reg_no', $this->reg_no])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'updated_ipaddress', $this->updated_ipaddress])
            ->andFilterWhere(['like', 'driver_profile.name', $this->driver_name])
            ->andFilterWhere(['like', 'client_master.company_name', $this->client_name]);

        return $dataProvider;
    }

     public function closedsearch($params,$map="")
    {  
         
           
    $query = Coupon::find()->where(['coupon_status'=>'C'])->joinWith(['vehicle','client','super'])->orderBy(['created_at'=>SORT_DESC])->limit(30);
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>false,
             
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
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'vehicle_name', $this->vehicle_name])
            ->andFilterWhere(['like', 'vehicle_uniqe_name', $this->vehicle_uniqe_name])
            ->andFilterWhere(['like', 'reg_no', $this->reg_no])
            ->andFilterWhere(['like', 'vehicle_master.status', $this->status])
            ->andFilterWhere(['like', 'updated_ipaddress', $this->updated_ipaddress])
            ->andFilterWhere(['like', 'vehicle_master.reg_no', $this->vehiclename])
            ->andFilterWhere(['like', 'client_master.company_name', $this->clientname])
            ->andFilterWhere(['like', 'superviser_master.name', $this->supervisorname]);

        return $dataProvider;
    }


    public function vehiclereportsearch($params,$map="")
    {  
         
           
        if(empty($_GET['fromdate']) && empty($_GET['todate']) && empty($_GET['reg_no']) && 
        empty($_GET['superviser']) && empty($_GET['client']) && empty($_GET['coupon_status'])){
    $query = Coupon::find()->where(['coupon_status'=>'D']);
//->joinWith(['vehicle','client','super','driver','bunk']);
//->join( 'INNER JOIN',  'tansi_product_model', 'tansi_product_model.prod_id =tansi_product.prod_id')
//->orderBy(['created_at'=>SORT_DESC]);

        }else{
        $query = new Query;
    $query  ->select(['*'])->from('coupon')
    ->where(['not',['bunk_name'=>'']])
   
     ->join('LEFT OUTER JOIN', 'vehicle_master','vehicle_master.id =coupon.vehicle_name')  
     ->join('LEFT OUTER JOIN', 'client_master','client_master.id = coupon.client_name')
     ->join('LEFT OUTER JOIN', 'superviser_master', 'superviser_master.id = coupon.superviser_id')
     ->join('LEFT OUTER JOIN', 'driver_profile','driver_profile.id = coupon.driver_name')
     ->join('LEFT OUTER JOIN', 'bunk_master','bunk_master.id = coupon.bunk_name');


    if($_GET['fromdate']!="" && $_GET['todate']!=""){
      $fromdate = date('Y-m-d 00:00:00', strtotime($_GET['fromdate']));
      $todate = date('Y-m-d 23:59:59', strtotime($_GET['todate'])); 
      $query ->andWhere(['BETWEEN','coupon.created_at',$fromdate,$todate]); 
    }

    if( $_GET['reg_no']!=""){ 
      $query ->andWhere(['coupon.vehicle_name'=>$_GET['reg_no']]); 
    }

    if( $_GET['superviser']!=""){ 
      $query ->andWhere(['superviser_id'=>$_GET['superviser']]);
    }

    if($_GET['client']!=""){ 
      $query ->andWhere(['coupon.client_name'=>$_GET['client']]);
    }

    if($_GET['coupon_status']!=""){ 
      $query ->andWhere(['coupon_status'=>$_GET['coupon_status']]);
    } 
        
        }// add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' =>false,
             
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
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query//->andFilterWhere(['like', 'vehicle_master.vehicle_name', $this->vehicle_name])
            ->andFilterWhere(['like', 'vehicle_uniqe_name', $this->vehicle_uniqe_name])
            ->andFilterWhere(['like', 'reg_no', $this->reg_no])
            ->andFilterWhere(['like', 'vehicle_master.status', $this->status]) 
            ->andFilterWhere(['like', 'updated_ipaddress', $this->updated_ipaddress]) 
            ->andFilterWhere(['like', 'vehicle_master.reg_no', $this->vehiclename])
            ->andFilterWhere(['like', 'client_master.company_name', $this->clientname])
            ->andFilterWhere(['like', 'superviser_master.name', $this->supervisorname])
            ->andFilterWhere(['like', 'driver_profile.name', $this->drivername])
            ->andFilterWhere(['like', 'bunk_master.bunk_agency_name', $this->bunkagencyname]);

        return $dataProvider;
    }
}
