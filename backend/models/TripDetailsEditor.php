<?php

namespace backend\models;

use Yii;
use yii\helpers\Url;
use Yii\helpers\ArrayHelper;

/**
 * This is the model class for table "trip_details".
 *
 * @property string $id
 * @property string $trip_title
 * @property string $customer_name
 * @property string $trip_type
 * @property string $pickup_type
 * @property string $trip_date_time
 * @property string $flight_number
 * @property string $vehicle_number
 * @property string $driver_name
 * @property string $vehicle_type
 * @property string $remarks
 * @property string $created_at
 * @property string $updated_at
 * @property string $updated_ipaddress
 * @property string $user_id
 */
class TripDetailsEditor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $files;
    public $person_name;
    public $company_names;
    public $tripcustomer1;
    public $tripcustomer2;
    public static function tableName()
    {
        return 'trip_details_editor';
    }

    /**
     * {@inheritdoc}
     */
public function rules()
{
    return [
        [['trip_date_time', 'created_at', 'updated_at'], 'safe'],
      
        [['vehicle_type', 'remarks'], 'string'],
        [['trip_title', 'vehicle_type', 'trip_date_time', 'customer_name','trip_customer1'], 'required'],
        [['customer_name', 'trip_type', 'pickup_type'], 'safe'],
    ];
}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trip_title' => 'Trip Code',
            'customer_name' => 'Customer Name',
            'trip_type' => 'Trip Type',
            'pickup_type' => 'Pickup Type',
            'trip_date_time' => 'Trip Date Time',
            'flight_number' => 'Flight Number',
            'vehicle_number' => 'Vehicle Number',
            'driver_name' => 'Driver Name',
            'vehicle_type' => 'Vehicle Type',
            'remarks' => 'Remarks',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_ipaddress' => 'Updated Ipaddress',
            'user_id' => 'User ID',
            'tripcustomer1'=>'Trip Customer',
            'tripcustomer2'=>'Trip Customer',
        ];
    }


    public function afterFind() {
        if(isset($this->customer->id)){   
            $this->person_name=$this->customer->company_name;  
        }if(isset($this->company->id)){   
            $this->company_names=$this->company->company_name;  
        }
    }
    public function getCustomer()
    {
        return $this->hasOne(CustomerDetails::className(), ['id' => 'customer_name']);
    }
    public function getCompany()
    {
        return $this->hasOne(ClientMaster::className(), ['id' => 'customer_name']);
    }

    public function ColseTripDetails($input=array())
    {
        $api_method = $login_key = $username = "";
        if(array_key_exists('api_method', $input)){
            $api_method = $input['api_method'];
        }if(array_key_exists('login_key', $input)){
            $login_key = $input['login_key'];
        }if(array_key_exists('login_name', $input)){
            $username = $input['login_name'];
        }
        $list['status'] = 'error';
        $list['message'] = 'Invalid Api Method';
        if($api_method=='close_trips'){
            $user_data_role = Triplogin::find()
                ->where(['username'=>$username])->asArray()
                ->one();
            $driver_name='';
            if($user_data_role){ 
                $driver_name = $user_data_role['first_name'].'  '.$user_data_role['last_name'];
            }
            $star = array('C');
            $trip_data = TripDetails::find()
                ->where(['IN','trip_current_status',$star])
                ->andWhere(['vehicle_number'=>$username])
                ->asArray()->all(); 
            $list['message'] = 'Not yet Closed any Trip';
            if(!empty($trip_data)){
                $det1 = array();
                $customer_data = CustomerDetails::find()->asArray()->all(); 
                $multicustomAr = ArrayHelper::index($customer_data,'id');
                $comp_Arr = ArrayHelper::map($customer_data,'id','company_name');
                $cust_Arr = ArrayHelper::map($customer_data,'id','contact_person');
                $cust_contact_Arr = ArrayHelper::map($customer_data,'id','company_contact_no');
                $cust_per_cont_Arr = ArrayHelper::map($customer_data,'id','personal_contact_no');
                $cust_Address_Arr = ArrayHelper::map($customer_data,'id','company_address');
                $cust_PersAdd_Arr = ArrayHelper::map($customer_data,'id','personal_address');

                $vehicle_data = VehicleMaster::find()->asArray()->all();
                $vehi_name_Arr = ArrayHelper::map($vehicle_data,'id','vehicle_name');
                $vehi_no_Arr = ArrayHelper::map($vehicle_data,'id','reg_no');

                $driver_data = DriverProfile::find()->asArray()->all(); 
                $driver_name_Arr = ArrayHelper::map($driver_data,'id','driver_name');
                $mobile_no_Arr = ArrayHelper::map($driver_data,'id','mobile_number');

                $trackids = ArrayHelper::map($trip_data,'id','id');
                $trackdetAr = AllenTripTrack::find()->where(['IN','trip_id',$trackids])->asArray()->all();
                $trackdetAr = ArrayHelper::index($trackdetAr,'trip_id');
                foreach ($trip_data as $key => $value) {
                    $det['trip_id'] = $value['id'];
                    $det['trip_code'] = $value['trip_title'];
                    $det['trip_type'] = ucfirst($value['trip_type']);
                    $det['pickup_type'] = ucfirst($value['pickup_type']);
                    $det['flight_number'] = $value['flight_number'];
                    $det['trip_date_time'] = date('d-m-Y h:i:s A',strtotime($value['trip_date_time']));
                    $det['vehicle_number'] = $value['vehicle_number'];
                    $det['vehicle_name'] = $value['vehicle_name'];
                    $det['driver_name'] = ucfirst($driver_name);
                    $det['vehicle_type'] = ucfirst($value['vehicle_type']);
                    $det['remarks'] = $value['remarks'];
                    $det['trip_created_date'] = date('d-m-Y h:i:s A',strtotime($value['created_at'])); 
                    $det['trip_modified_date'] = date('d-m-Y h:i:s A',strtotime($value['updated_at'])); 
                    $det['status'] = $value['status'];
                    $det['customer_company_name'] ='';

                    $det['trip_uploadedimage'] = "";
                    if($value['image_upload']!="" && $value['image_upload']!=NULL){
                        $det['trip_uploadedimage'] = Url::home(true).'backend/web/'.$value['image_upload'];
                    }


                    if(array_key_exists($value['customer_name'], $comp_Arr)){
                        $det['customer_company_name'] = $comp_Arr[$value['customer_name']];
                    }
                    $det['customer_name'] = $det['customer_personal_address'] = $det['customer_office_address'] = $det['customer_personal_no'] = $det['customer_office_no'] = '';
                    if(array_key_exists($value['trip_customer1'], $multicustomAr)){
                        $det['customer_name'] = $multicustomAr[$value['trip_customer1']]['contact_person'];
                        $det['customer_personal_address'] = $multicustomAr[$value['trip_customer1']]['personal_address'];
                        $det['customer_office_address'] = $multicustomAr[$value['trip_customer1']]['company_address'];
                        $det['customer_personal_no'] = $multicustomAr[$value['trip_customer1']]['personal_contact_no'];
                        $det['customer_office_no'] = $multicustomAr[$value['trip_customer1']]['company_contact_no'];
                    }
                    $det['customer_name2'] = $det['customer_personal_address2'] = $det['customer_office_address2'] = $det['customer_personal_no2'] = $det['customer_office_no2'] = '';
                    if(array_key_exists($value['trip_customer2'], $multicustomAr)){
                        $det['customer_name2'] = $multicustomAr[$value['trip_customer2']]['contact_person'];
                        $det['customer_personal_address2'] = $multicustomAr[$value['trip_customer2']]['personal_address'];
                        $det['customer_office_address2'] = $multicustomAr[$value['trip_customer2']]['company_address'];
                        $det['customer_personal_no2'] = $multicustomAr[$value['trip_customer2']]['personal_contact_no'];
                        $det['customer_office_no2'] = $multicustomAr[$value['trip_customer2']]['company_contact_no'];
                    }
                    $det['general_address'] = "";
                    if($value['pickup_type']=='general'){
                        $det['general_address'] = $value['general_address'];
                    }

                    /*if(array_key_exists($value['customer_name'], $cust_Arr)){
                        $det['customer_name'] = ucfirst($cust_Arr[$value['customer_name']]);
                    }
                    if(array_key_exists($value['customer_name'], $cust_PersAdd_Arr)){
                        $det['customer_personal_address'] = $cust_PersAdd_Arr[$value['customer_name']];
                    }
                    if(array_key_exists($value['customer_name'], $cust_Address_Arr)){
                        $det['customer_office_address'] = $cust_Address_Arr[$value['customer_name']];
                    }
                    if(array_key_exists($value['customer_name'], $cust_per_cont_Arr)){
                        $det['customer_personal_no'] = $cust_per_cont_Arr[$value['customer_name']];
                    }
                    if(array_key_exists($value['customer_name'], $cust_contact_Arr)){
                        $det['customer_office_no'] = $cust_contact_Arr[$value['customer_name']];
                    }
                    $det['customer_company_name2'] ='';
                    if(array_key_exists($value['customer_name'], $comp_Arr)){
                        $det['customer_company_name2'] = $comp_Arr[$value['customer_name']];
                    }
                    $det['customer_name2'] ='';
                    if(array_key_exists($value['customer_name'], $cust_Arr)){
                        $det['customer_name2'] = ucfirst($cust_Arr[$value['customer_name']]);
                    }
                    $det['customer_personal_address2'] ='';
                    if(array_key_exists($value['customer_name'], $cust_PersAdd_Arr)){
                        $det['customer_personal_address2'] = $cust_PersAdd_Arr[$value['customer_name']];
                    }
                    $det['customer_office_address2'] =''; 
                    if(array_key_exists($value['customer_name'], $cust_Address_Arr)){
                        $det['customer_office_address2'] = $cust_Address_Arr[$value['customer_name']];
                    }
                    $det['customer_personal_no2'] ='';
                    if(array_key_exists($value['customer_name'], $cust_per_cont_Arr)){
                        $det['customer_personal_no2'] = $cust_per_cont_Arr[$value['customer_name']];
                    }
                    $det['customer_office_no2'] ='';
                    if(array_key_exists($value['customer_name'], $cust_contact_Arr)){
                        $det['customer_office_no2'] = $cust_contact_Arr[$value['customer_name']];
                    }*/
                    $det['expense1_reason'] = $det['expense2_reason']  = $det['expense3_reason'] = $det['digital_signature'] = $det['trip_start_time'] = $det['trip_end_time'] = $det['starting_km'] = $det['close_km'] = ""; 
                    $det['expense1_amt'] = $det['expense2_amt'] = $det['expense3_amt'] = "0";
                    if(array_key_exists($value['id'], $trackdetAr)){
                        if(array_key_exists('expenses_1', $trackdetAr[$value['id']])){
                            if($trackdetAr[$value['id']]['expenses_1']!="" && $trackdetAr[$value['id']]['expenses_1']!=NULL){
                                $det['expense1_reason'] = $trackdetAr[$value['id']]['expenses_1'];
                            }
                        }if(array_key_exists('expenses_2', $trackdetAr[$value['id']])){
                            if($trackdetAr[$value['id']]['expenses_2']!="" && $trackdetAr[$value['id']]['expenses_2']!=NULL){
                                $det['expense2_reason'] = $trackdetAr[$value['id']]['expenses_2'];
                            }
                        }if(array_key_exists('expenses_3', $trackdetAr[$value['id']])){
                            if($trackdetAr[$value['id']]['expenses_3']!="" && $trackdetAr[$value['id']]['expenses_3']!=NULL){
                                $det['expense3_reason'] = $trackdetAr[$value['id']]['expenses_3'];
                            }
                        }if(array_key_exists('expenses_1_amt', $trackdetAr[$value['id']])){
                            if($trackdetAr[$value['id']]['expenses_1_amt']!="" && $trackdetAr[$value['id']]['expenses_1_amt']!=NULL){
                                $det['expense1_amt'] = $trackdetAr[$value['id']]['expenses_1_amt'];
                            }
                        }if(array_key_exists('expenses_2_amt', $trackdetAr[$value['id']])){
                            if($trackdetAr[$value['id']]['expenses_2_amt']!="" && $trackdetAr[$value['id']]['expenses_2_amt']!=NULL){
                                $det['expense2_amt'] = $trackdetAr[$value['id']]['expenses_2_amt'];
                            }
                        }if(array_key_exists('expenses_3_amt', $trackdetAr[$value['id']])){
                            if($trackdetAr[$value['id']]['expenses_3_amt']!="" && $trackdetAr[$value['id']]['expenses_3_amt']!=NULL){
                                $det['expense3_amt'] = $trackdetAr[$value['id']]['expenses_3_amt'];
                            }
                        }if(array_key_exists('enter_starting_km', $trackdetAr[$value['id']])){
                            if($trackdetAr[$value['id']]['enter_starting_km']!="" && $trackdetAr[$value['id']]['enter_starting_km']!=NULL){
                                $det['starting_km'] = $trackdetAr[$value['id']]['enter_starting_km'];
                            }
                        }if(array_key_exists('enter_close_km', $trackdetAr[$value['id']])){
                            if($trackdetAr[$value['id']]['enter_close_km']!="" && $trackdetAr[$value['id']]['enter_close_km']!=NULL){
                                $det['close_km'] = $trackdetAr[$value['id']]['enter_close_km'];
                            }
                        }
                        if(array_key_exists('digital_signature', $trackdetAr[$value['id']])){
                            if($trackdetAr[$value['id']]['digital_signature']!="" && $trackdetAr[$value['id']]['digital_signature']!=NULL){
                                $det['digital_signature'] = Url::home(true).$trackdetAr[$value['id']]['digital_signature'];
                            }
                        }if(array_key_exists('trip_start_time', $trackdetAr[$value['id']])){
                            if($trackdetAr[$value['id']]['trip_start_time']!="" && $trackdetAr[$value['id']]['trip_start_time']!=NULL){
                                $det['trip_start_time'] = date('d-m-Y H:i A', strtotime($trackdetAr[$value['id']]['trip_start_time']));
                            }
                        }if(array_key_exists('trip_end_time', $trackdetAr[$value['id']])){
                            if($trackdetAr[$value['id']]['trip_end_time']!="" && $trackdetAr[$value['id']]['trip_end_time']!=NULL){
                                $det['trip_end_time'] = date('d-m-Y H:i A', strtotime($trackdetAr[$value['id']]['trip_end_time']));
                            }
                        }
                    }
                    $det1[]=$det;
                }
                $list['status']='success';
                $list['message']='Closed Lists';
                $list['trip_list'] = $det1;
            }
        }
        return $list;
    }  

    public function ExpenseEdit($input=array(),$files=array())
    {


        $api_method = $tripid = $expenses_1 = $expenses_2 = $expenses_3 = $expenses_1_file = $expenses_2_file = $expenses_3_file = "";
        $exp1amt = $exp2amt = $exp3amt = "0";
        if(array_key_exists('api_method', $input)){
            $api_method = $input['api_method'];
        }if(array_key_exists('expenses_1_amt', $input)){
            if($input['expenses_1_amt']!=""){
                $exp1amt = $input['expenses_1_amt'];
            }
        }if(array_key_exists('expenses_2_amt', $input)){
            if($input['expenses_2_amt']!=""){
                $exp2amt = $input['expenses_2_amt'];
            }
        }if(array_key_exists('expenses_3_amt', $input)){
            if($input['expenses_3_amt']!=""){
                $exp3amt = $input['expenses_3_amt'];
            }
        }if(array_key_exists('expenses_1', $input)){
            if($input['expenses_1']!=""){
                $expenses_1 = $input['expenses_1'];
            }
        }if(array_key_exists('expenses_2', $input)){
            if($input['expenses_2']!=""){
                $expenses_2 = $input['expenses_2'];
            }
        }if(array_key_exists('expenses_3', $input)){
            if($input['expenses_3']!=""){
                $expenses_3 = $input['expenses_3'];
            }
         }if(array_key_exists('expenses_1_file', $input)){
            if($input['expenses_1_file']!=""){
                $expenses_3 = $input['expenses_1_file'];
            }
        }if(array_key_exists('expenses_2_file', $input)){
            if($input['expenses_2_file']!=""){
                $expenses_3 = $input['expenses_2_file'];
            }
        }if(array_key_exists('expenses_3_file', $input)){
            if($input['expenses_3_file']!=""){
                $expenses_3 = $input['expenses_3_file'];
            }           
        }if(array_key_exists('trip_id', $input)){
            $tripid = $input['trip_id'];
        }


        $list['status'] = 'error';
        $list['message'] = 'Invalid Api Method';
        if($api_method=='edit_expense'){
            $list['message'] = 'Trip Not Found';
            $trip = AllenTripTrack::find()->where(['trip_id'=>$tripid])->one();
            if($trip){
                $list['message']='Trip Not Closed';
                if($trip->trip_status=='F'){
                    $list['message']='Trip Finished Already';
                }
                if($trip->trip_status=='C'){
                    $trip->trip_status='F';
                    if($expenses_1!=""){
                        $trip->expenses_1=$expenses_1;
                    }if($expenses_2!=""){
                        $trip->expenses_2=$expenses_2;
                    }if($expenses_3!=""){
                        $trip->expenses_3=$expenses_3;
                    }if($expenses_1_file!=""){
                        $trip->expenses_1_file=$expenses_1_file; 
                    }if($expenses_2_file!=""){
                        $trip->expenses_2_file=$expenses_2_file;
                    }if($expenses_3_file!=""){
                        $trip->expenses_3_file=$expenses_3_file;           
                    }if($exp1amt!=""){
                        $trip->expenses_1_amt=$exp1amt;
                    }if($exp2amt!=""){
                        $trip->expenses_2_amt=$exp2amt;
                    }if($exp3amt!=""){
                        $trip->expenses_3_amt=$exp3amt;
                    }

            if(isset($files['expenses_1_file']['name'])!='')
                {
                    $uploads_dir = 'backend/web/uploads/trip_expenses/';         
                       $tmp_name =$files["expenses_1_file"]["tmp_name"];
                        $file_name = rand().$files["expenses_1_file"]["name"];
                     $uploads_dir = 'backend/web/uploads/trip_expenses/'.$file_name;
                     $uploads_dir1 = 'trip_expenses/'.$file_name;
                     move_uploaded_file($tmp_name, $uploads_dir);
                     $trip->expenses_1_file=$uploads_dir1;
                }
           if(isset($files['expenses_2_file']['name'])!='')
                {
                    $uploads_dir = 'backend/web/uploads/trip_expenses/';         
                       $tmp_name =$files["expenses_2_file"]["tmp_name"];
                        $file_name = rand().$files["expenses_2_file"]["name"];
                     $uploads_dir = 'backend/web/uploads/trip_expenses/'.$file_name;
                     $uploads_dir1 = 'trip_expenses/'.$file_name;
                     move_uploaded_file($tmp_name, $uploads_dir);
                     $trip->expenses_2_file=$uploads_dir1;
                }
              if(isset($files['expenses_3_file']['name'])!='')
                {
                    $uploads_dir = 'backend/web/uploads/trip_expenses/';         
                       $tmp_name =$files["expenses_3_file"]["tmp_name"];
                        $file_name = rand().$files["expenses_3_file"]["name"];
                     $uploads_dir = 'backend/web/uploads/trip_expenses/'.$file_name;
                     $uploads_dir1 = 'trip_expenses/'.$file_name;
                     move_uploaded_file($tmp_name, $uploads_dir);
                     $trip->expenses_3_file=$uploads_dir1;
                }  



                    if($trip->save()){
                        $tpdet = TripDetails::findOne($tripid);
                        if($tpdet){
                            $tpdet->trip_current_status='F';
                            $tpdet->save();
                        }
                        $list['status'] = 'success';
                        $list['message'] = 'Trip Finished Successfully';
                    }
                }
            }
        }
        return $list;
    }  
}
