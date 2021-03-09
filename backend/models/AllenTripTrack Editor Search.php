<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AllenTripTrack;
use backend\models\TripDetails;
use backend\models\CustomerDetails;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
 * AllenTripTrackSearch represents the model behind the search form of `backend\models\AllenTripTrack`.
 */
class AllenTripTrackEditorSearch extends AllenTripTrackEditor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'enter_starting_km', 'enter_close_km'], 'integer'],
            [['trip_id', 'customer_id', 'trip_start_time', 'trip_end_time', 'start_trip', 'close_trip', 'expenses_1', 'expenses_2', 'expenses_3', 'digital_signature', 'status', 'trip_status', 'created_at', 'modified_at', 'updated_ipaddress', 'device_name', 'driver_name', 'vehicle_number'], 'safe'],
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
        $query = AllenTripTrack::find();

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

        $query->andFilterWhere(['like', 'trip_id', $this->trip_id])
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

    public function tripreport($get_post_value='')
    {
       $objPHPExcel = new Spreadsheet();
       $sheet = 0;              
                        
                                        $styleArray_header = array(
                        'font'  => array(
                        'bold'  => true,
                        //'color' => array('rgb' => 'FF0000'),
                        'size'  => 12,
                        'name'  => 'Calibri'
                        ));
                
                               $styleCalibri = array(
                        'font'  => array(
                        'bold'  => true,
                        //'color' => array('rgb' => 'FF0000'),
                        'size'  => 10,
                        'name'  => 'Calibri'
                        ));
                                       // print_r($get_post_value);die;

                        $query = new Query;
                       $query  ->select(['*'])->from('trip_details');
                       if($get_post_value['FROM_DATE']!="" && $get_post_value['TO_DATE']!=""){
                         $fromdate = date('Y-m-d 00:00:00', strtotime($get_post_value['FROM_DATE']));
                         $todate = date('Y-m-d 23:59:59', strtotime($get_post_value['TO_DATE']));
                         $query ->andWhere(['BETWEEN','created_at',$fromdate,$todate]);
                       }
                       if( $get_post_value['VehicleMaster']['vehicle_name'] !=""){
                         $query ->andWhere(['vehicle_name'=>$get_post_value['VehicleMaster']['vehicle_name']]);
                       }

                       if( $get_post_value['VehicleMaster']['reg_no'] !=""){
                         $query ->andWhere(['vehicle_number'=>$get_post_value['VehicleMaster']['reg_no']]);
                       }
                      
                       //$query ->limit(200);
                       $command = $query->createCommand();
                       $un_send_data = $command->queryAll();

                      // trip_id

                       $allen_trip_track_map=ArrayHelper::map($un_send_data,'id','id');

                       $allen_trip_track=AllenTripTrack::find()->where(['IN','trip_id',$allen_trip_track_map])->asArray()->all();

                       $allen_trip_track_index=ArrayHelper::index($allen_trip_track,'trip_id');
                        
                       $customer_details=ArrayHelper::index(CustomerDetails::find()->asArray()->all(),'id');



                      // echo '<pre>';
                       //print_r($customer_details);die;


                        $objPHPExcel -> setActiveSheetIndex($sheet);
                        $objPHPExcel -> getActiveSheet() -> setTitle("Trip Report") 
                        -> setCellValue('A1', 'SNO')
                        -> setCellValue('B1', 'DATE')
                        -> setCellValue('C1', 'CUSTOMER NAME')
                        -> setCellValue('D1', 'Pickup / Drop')
                        -> setCellValue('E1', 'Airport / General')
                        -> setCellValue('F1', 'Vehicle Number')
                        -> setCellValue('G1', 'Vehicle Type')
                        -> setCellValue('H1', 'Starting KM')
                        -> setCellValue('I1', 'Closing KM')
                        -> setCellValue('J1', 'Total KM')
                        -> setCellValue('K1', 'Starting Time')
                        -> setCellValue('L1', 'Ending Time')
                        -> setCellValue('M1', 'Trip Time');

                        $objPHPExcel->getActiveSheet()->getStyle('A1'.':'.'M1')->applyFromArray($styleArray_header);

                        $all_post_key = array("SNO","DATE","CUSTOMER NAME","Pickup","Airport","Vehicle","Vehicle Type","Starting KM","Closing KM","Total KM","Starting Time","Ending Time","Trip Time");

                        $slno=1;
                        $row = 2;
                        $r=4;
                        foreach($un_send_data as $key => $one_data)
                        {
                            
                            $r_a=65;$r_a1=64;
                            
                           /* $allen_trip_track=
                            if(array_key_exists($one_data['id'], $allen_trip_track_index))
                            {
                                $allen_trip_track_index   
                            }*/
                            $customer_name1='';//$customer_name2='';
                            if(array_key_exists($one_data['trip_customer1'], $customer_details))
                            {
                                $customer_name1=$customer_details[$one_data['trip_customer1']]['contact_person'];
                            }

                            if(array_key_exists($one_data['trip_customer2'], $customer_details))
                            {
                                $customer_name1.=','.$customer_details[$one_data['trip_customer2']]['contact_person'];
                            }

                            $start_km=0;
                            $closing_km=0;
                            $total_km=0;

                            $starting_time='';
                            $ending_time='';
                            $trip_time='';
                            if(array_key_exists($one_data['id'],  $allen_trip_track_index))
                            {
                                 if(!empty($allen_trip_track_index[$one_data['id']]['enter_starting_km']))
                                 {
                                    $start_km=$allen_trip_track_index[$one_data['id']]['enter_starting_km'];
                                 }
                                 
                                 if(!empty($allen_trip_track_index[$one_data['id']]['enter_close_km']))
                                 {
                                    $closing_km=$allen_trip_track_index[$one_data['id']]['enter_close_km'];
                                 }

                                 $total_km=abs($start_km - $closing_km);

                                 if(!empty($allen_trip_track_index[$one_data['id']]['trip_start_time']))
                                 {
                                    $starting_time=date('d-m-Y h:i:s',strtotime($allen_trip_track_index[$one_data['id']]['trip_start_time']));
                                 }

                                 if(!empty($allen_trip_track_index[$one_data['id']]['trip_end_time']))
                                 {
                                    $ending_time=date('d-m-Y h:i:s',strtotime($allen_trip_track_index[$one_data['id']]['trip_end_time']));
                                 }

                                 if(!empty($allen_trip_track_index[$one_data['id']]['trip_start_time']) && !empty($allen_trip_track_index[$one_data['id']]['trip_end_time']))
                                 {
                                     $starting_time=date('d-m-Y h:i:s',strtotime($allen_trip_track_index[$one_data['id']]['trip_start_time']));
                                     $ending_time=date('d-m-Y h:i:s',strtotime($allen_trip_track_index[$one_data['id']]['trip_end_time']));

                                       $difference = abs(strtotime($ending_time) - strtotime($starting_time));
                                       $hours = floor($difference/3600);
                                       $minutes = floor(($difference/60)%60);
                                       $seconds = $difference%60;
                                       $trip_time = $hours.':'.$minutes.':'.$seconds;
                                 }

                                  
                                   

                            }

                            foreach($all_post_key as $one_field)
                            {
                                 
                                
                                $cell_char=chr($r_a);
                                
                                if($r_a1>=65)
                                {
                                    $cell_char=chr($r_a1).chr($r_a);    
                                }

                                if($one_field=='SNO')
                                {
                                     
                                    $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $slno);
                                    $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->applyFromArray($styleCalibri);
                                }
                                else
                                {

                                    if($one_field=='DATE')
                                    {
                                         $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, date('d-m-Y',strtotime($one_data['created_at'])));
                                         $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->applyFromArray($styleCalibri);
                                    }
                                    else if($one_field=='CUSTOMER NAME')
                                    {
                                         $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, strtoupper($customer_name1));
                                         $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->applyFromArray($styleCalibri);
                                    }   
                                    else if($one_field=='Pickup')
                                    {
                                         $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, strtoupper($one_data['trip_type']));
                                         $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->applyFromArray($styleCalibri);
                                    }
                                    else if($one_field=='Airport')
                                    {
                                         $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, strtoupper($one_data['pickup_type']));
                                         $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->applyFromArray($styleCalibri);
                                    }
                                    else if($one_field=='Vehicle')
                                    {
                                          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, strtoupper($one_data['vehicle_name']));
                                          $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->applyFromArray($styleCalibri);
                                    }
                                    else if($one_field=='Vehicle Type')
                                    {
                                         $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, strtoupper($one_data['vehicle_type']));
                                         $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->applyFromArray($styleCalibri);
                                    }
                                    else if($one_field=='Starting KM')
                                    {
                                         $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $start_km);
                                         $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->applyFromArray($styleCalibri);   
                                    }
                                    else if($one_field=='Closing KM')
                                    {
                                        $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $closing_km);
                                        $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->applyFromArray($styleCalibri); 
                                       
                                    }
                                    else if($one_field=='Total KM')
                                    {
                                        $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $total_km);
                                        $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->applyFromArray($styleCalibri); 
                                    }
                                    else if($one_field=='Starting Time')
                                    {
                                        $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $starting_time);
                                        $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->applyFromArray($styleCalibri);
                                    }
                                    else if($one_field=='Ending Time')
                                    {
                                        $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $ending_time);
                                        $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->applyFromArray($styleCalibri); 
                                    }
                                    else if($one_field=='Trip Time')
                                    {
                                        
                                        $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $trip_time);
                                        $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->applyFromArray($styleCalibri); 
                                    }
                                   
                                   
                                }

                                if($r_a>=90)
                                {
                                    $r_a=64;
                                    $r_a1++;
                                }
                                $r_a++;

                            }

                            $slno++;            
                            $row++;
                        }


                        $objWriter = new Xlsx($objPHPExcel); 
                        $filename = "TripReport_".date("d-m-Y-His").".xlsx";
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename='.$filename); 
                        header('Cache-Control: max-age=0');   
                        header("Pragma: no-cache");
                        header("Expires: 0");
                        ob_end_clean();
                        $objWriter->save('php://output');  

    }
}
