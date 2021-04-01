<?php

namespace backend\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "trip_details".
 *
 * @property string $id
 * @property string $tripcode
 * @property string $CustomerId
 * @property string $DriverId
 * @property string $VehicleId
 * @property string $VehicleType
 * @property string $VehicleMade
 * @property string $VehicleNo
 * @property string $TripType
 * @property string $TripScheduleType
 * @property string $ChangeTrip
 * @property string $Changeof
 * @property string $ChangeReason
 * @property string $TripStartLoc
 * @property string $TripEndLoc
 * @property string $StartDateTime
 * @property string $EndDateTime
 * @property double $TripCost
 * @property string $Review
 * @property string $CommissionId
 * @property string $CommissionType
 * @property double $CommissionAmount
 * @property string $CreatedDate
 * @property string $UpdatedDate
 * @property string $UpdatedIpaddress
 */
class TripDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_details';
    }

    /**
     * {@inheritdoc}
     */
    public $CustomerName;
    //public $GuestName;
    public $CustomerContactNo;
    public $DriverName;
    public $DriverContactNo;
    public function rules()
    {
        return [
            [['CustomerId', 'VehicleType', 'TripType','StartDateTime',], 'required'],
            [['ChangeTrip', 'ChangeReason', 'TripStartLoc', 'TripEndLoc', 'Review', 'UpdatedIpaddress'], 'safe'],
            [['StartDateTime', 'EndDateTime', 'CreatedDate', 'UpdatedDate'], 'safe'],
            [['TripCost', 'CommissionAmount'], 'number'],
            [['tripcode', 'VehicleType', 'VehicleMade', 'TripScheduleType'], 'safe'],
            [['CustomerId', 'DriverId', 'VehicleId', 'VehicleNo', 'TripType'], 'safe'],
            [['DriverId'],'required','on'=>['activate']],
            [['DriverId'],'required','on'=>['change-trip']],
            [['CommissionType','EndDateTime','TripHours','TripCost'],'required','on'=>['complete']],
            [['CancelFee','CancelReason','CancelFeeStatus'],'required','on'=>['cancel']],

            ['CommissionId', 'required', 'when' => function ($model) { 
              return $model->CommissionType == "Percentage"; 
                }, 
              'whenClient' => "function (attribute, value) {   
                  return $('#tripdetails-commissiontype').val()=='Percentage'; 
              }"
            ],
             ['CommissionValue', 'required', 'when' => function ($model) { 
              return $model->CommissionType == "Flat"; 
                }, 
              'whenClient' => "function (attribute, value) {   
                  return $('#tripdetails-commissiontype').val()=='Flat'; 
              }"
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tripcode' => 'Booking Code',
            'CustomerId' => 'Company Name',
            'UserType' => 'Customer Type',
            'DriverId' => 'Driver Name',
            'GuestContact' => 'Customer Contact',
            'GuestName' => 'Customer Name',
            'VehicleId' => 'Vehicle ID',
            'VehicleType' => 'Vehicle Type',
            'VehicleMade' => 'Vehicle Brand',
            'VehicleNo' => 'Vehicle No',
            'TripType' => 'Trip Type',
            'TripScheduleType' => 'Trip Schedule Type',
            'ChangeTrip' => 'Change Trip',
            'ChangeReason' => 'Change Reason',
            'TripStartLoc' => 'Trip Start Location',
            'TripEndLoc' => 'Trip End Location',
            'StartDateTime' => 'Trip Starting Date Time',
            'EndDateTime' => 'Trip Closing Date Time',
            'TripCost' => 'Trip Cost',
            'Review' => 'Review',
            'CommissionId' => 'Commission value',
            'CommissionType' => 'Commission Type',
            'CommissionAmount' => 'Commission Amount',
            'CreatedDate' => 'Booked Date',
            'UpdatedDate' => 'Updated Date',
            'UpdatedIpaddress' => 'Updated Ipaddress',
        ];
    }
     public function afterFind() { 
        if(isset($this->client->id)){   
            $this->CustomerName=$this->client->client_name.' - '.$this->client->company_name;   
            $this->CustomerContactNo=$this->client->mobile_no;   
          //  $this->GuestName=$this->client->guest_name;   
        }else{
            $this->CustomerName="Not Set";  
            $this->CustomerContactNo="Not Set";  
            //$this->GuestName="Not Set";  
        }

         if(isset($this->driver->id)){   
            $this->DriverName=$this->driver->name.' - '.$this->driver->employee_id;   
            $this->DriverContactNo=$this->driver->mobile_number;   
        }else{
            $this->DriverName="Not Set";  
            $this->DriverContactNo="Not Set";  
        }
    }
  
    public function getClient()
    {
        return $this->hasOne(ClientMaster::className(), ['id' => 'CustomerId']);
    }

    public function getDriver()
    {
        return $this->hasOne(DriverProfile::className(), ['id' => 'DriverId']);
    }


    public function tripsheet($id){ 

        require ('../../vendor/tcpdf/tcpdf.php');
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 8, '', true);
        $pdf->SetMargins(10, false, 10, true); // set the margins 
        $pdf->AddPage('P','A5');
       
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        //$pdf->AddPage();
       
       $sno=1;
         $cust_id ="";
            $driv_id="";
            $GuestName ="";
            $GuestContact ="";
            $BookingNo ="";
            $BookingDate ="";
            $DutyType ="";
            $VehicleType ="";
            $VehicleNo ="";
            $pickupLoc ="";
            $dropLoc ="";
            $StartDate ="";
            $StartTime ="";
            $CloseDate ="";
            $CloseTime ="";
            $customername ="";
            $customercontact ="";
            $drivername ="";
            $drivercontact ="";
            $UserType="";
            //$id="1";
       $model = TripDetails::find()->where(['id'=>$id])->asArray()->one();
          
            if (!empty($model)) {
                $cust_id = $model['CustomerId'];
                $driv_id = $model['DriverId'];
                $GuestName = $model['GuestName'];
                $GuestContact = $model['GuestContact'];
                $BookingNo = $model['tripcode'];
                $BookingDate = date('d-m-Y h:i A', strtotime($model['CreatedDate']));
                $DutyType = $model['TripType'];
                $VehicleType = $model['VehicleType'];
                $VehicleNo = $model['VehicleNo'];
                $pickupLoc = $model['TripStartLoc'];
                $dropLoc = $model['TripEndLoc'];
               
                 if (strpos($model['StartDateTime'], '0000') || strpos($model['StartDateTime'], '1970')) {
                    
                }else{
                     $StartDate = date('d-m-Y', strtotime($model['StartDateTime']));
                     $StartTime = date('h:i A', strtotime($model['StartDateTime']));
                }
                if (strpos($model['EndDateTime'], '0000') || strpos($model['EndDateTime'], '1970')) {
                    
                }else{
                    $CloseDate = date('d-m-Y', strtotime($model['EndDateTime']));
                    $CloseTime = date('h:i A', strtotime($model['EndDateTime'])); 
                }
                

                $cust_id = $model['CustomerId'];
                $driv_id = $model['DriverId'];
                 $customer = ClientMaster::find()->where(['id'=>$cust_id])->asArray()->one();
                 if (!empty($customer)) {
                    $customername = $customer['client_name'];
                    $customercontact = $customer['mobile_no']; 
                    $UserType = $customer['UserType'];
                 }
                 $driver = DriverProfile::find()->where(['id'=>$driv_id])->asArray()->one();
                 if (!empty($customer)) {
                    $drivername = $driver['name'];
                    $drivercontact = $driver['mobile_number']; 
                 }
            }
       $baseUrl = Url::base(true);
        $files=$baseUrl.'/images/logo.png';
        $filetype = explode('.', $files);
       $pdf->Image( $files, 14, 16, 25, '', 'PNG', '', '', false, 500, '', false, false, 0, false, false, false);
      $html = '
      <html>
      <style>
      .custom-font{
        font-size:12px;
      }
      .border-cl{ 
        margin-bottom:100px;
      }
      .border-cs{
        border-style: solid;
      }
       .border-cs1{ 
        margin-bottom: 1px;
      }
      .ht-cs{
        
      }
      .text-right{
        text-align:right;
      }
      .text-left{
        text-align:left;
      }
      .text-center{
        text-align:center;
      }
      .head-cs{ 
       color:white;
      }
      .td-br{ 
       border: 1px solid;
      }
	  .f-16{
		  font-size:10px;
	  }
	  .f-18{
		    font-size:10px;
	  }
     </style>
     <body>

    <div class="border-cl"></div><br> 
    <table width="100%" style="text-align:right; border-top: 1px solid #000; border-right: 1px solid #000;border-left:1px solid #000; padding:5px;">
        <tr class="">
        <td class="text-center">
        <h4 style="color: #E27D29;">DRIVES2U CALL DRIVER SERVICE PRIVATE LIMITED</h4> 
        </td>
        </tr> 
         <tr class="">
        <td class="text-center">
        &nbsp;&nbsp;&nbsp;&nbsp;284/9. Thiruvalluvar Street, Keelkattalai,
        </td>
        </tr>
        <tr class="">
        <td class="text-center">
        &nbsp;&nbsp;&nbsp;&nbsp;Chennai, Tamil Nadu,India, 6000117
        </td>
        </tr>
        <tr class="">
        <td class="text-center">
        Corporate Office:&nbsp;044 - 2247 2229
        </td>
        </tr>
    </table>


    <table width="100%" cellpadding="4" cellspacing="3" style="border: 1px solid #000;">
		<tr>
		  <td><b style="font-size:16px;text-align:center; margin:10px;">Duty Slip</b></td>
		</tr>
    </table>

    <table width="100%" cellspacing="3" style="border-right: 1px solid #000;border-left:1px solid #000;  padding:5px;">
        <tr class="ht-cs" rowspan="1">
        <td width="50%" class="f-16 text-left">Booking Number:&nbsp;&nbsp;'.$BookingNo.'</td>
      
        <td width="50%" class="text-right f-16">Booking Date:&nbsp;&nbsp;'.$BookingDate.'</td>
        </tr>
        <tr class="ht-cs">
        <td width="100%" class="text -center"><b class="f-18">Customer Details</b></td>
        </tr>';
        if ($UserType=="Home") {
             $html .='
                <tr class="ht-cs">
                <td width="50%" class="f-16">Customer Name:&nbsp;&nbsp;'.ucwords($customername).'</td>
                 
                <td width="50%" class="f-16 text-right">Mobile No:&nbsp;&nbsp;'.$customercontact.'</td> 
                </tr></table>';
        }else if ($UserType=="Company") {
                 $html .='
                <tr class="ht-cs">
                <td width="36%" class="f-16">Company Name:&nbsp;&nbsp;'.ucwords($customername).'</td> 
                <td width="34%" class="f-16">Customer Name:&nbsp;&nbsp;'.ucwords($GuestName).'</td> 
                <td width="30%" class="f-16">Mobile No:&nbsp;&nbsp;'.$GuestContact.'</td> 
                </tr></table>';
        }
        $html .='
        

    <table width="100%" cellspacing="3" style=" border-right: 1px solid #000;border-left:1px solid #000; border-top:1px solid #000;  padding:5px;">
         <tr class="ht-cs">
        <td width="100%" class="text- center"><b class="f-18">Trip Details</b></td>
        </tr>
        <tr class="ht-cs">
        <td width="32%" class="f-16">Duty Type:&nbsp;&nbsp;'.ucwords($DutyType).'</td> 
        <td class="f-16" style="width:160px; word-wrap:break-word;">Pickup Location:&nbsp; &nbsp;'.$pickupLoc.'</td> 
        <td class="f-16" style="width:130px; word-wrap:break-word;">Drop Location: &nbsp;&nbsp;'.$dropLoc.'</td> 
        </tr>
        <tr class="ht-cs">
        <td width="32%" class="f-16">Start Date:&nbsp;&nbsp;'.$StartDate.'</td> 
        <td width="37%" class="f-16">Close Date:&nbsp;&nbsp;</td> 
        <td width="31%" class="f-16">Total Days:</td>
        </tr>
        <tr class="ht-cs">
        <td width="32%" class="f-16">Start Time:&nbsp;&nbsp;'.$StartTime.'</td>
        <td width="37%" class="f-16">Close Time:</td>
        <td width="31%" class="f-16">Total Hours:</td>
        </tr>
        <tr class="ht-cs">
        <td width="32%" class="f-16">Start Km:</td>
        <td width="37%" class="f-16">Close Km:</td>
        <td width="31%" class="f-16">Total Kms:</td>
        </tr>  
    </table>
     <table cellspacing="3" style="border: 1px solid #000; solid #000;  padding:5px;">
        <tr class="ht-cs">
        <td width="100%" class="text- center"><b class="f-18">Driver Details</b></td>
        </tr>
        <tr class="ht-cs">
        <td width="50%" class="f-16">Driver Name:&nbsp;&nbsp;'.ucwords($drivername).'</td>
        <td width="50%" class="f-16">Mobile No: &nbsp;&nbsp;'.$drivercontact.'</td>
        </tr>
        <tr class="ht-cs">
        <td width="50%" class="f-16">Vehicle Type:&nbsp;&nbsp;'.ucwords($VehicleType).'</td> 
        <td width="50%" class="f-16">Vehicle No:&nbsp;&nbsp;'.ucwords($VehicleNo).'</td> 
        </tr>
    </table>
    <table  cellspacing="3" width="100%" style="border: 1px solid #000;  padding:5px;">
        <tr class="ht-cs">
        <td width="50%" class="f-18">Payment Type:</td>
        <td width="17%"></td> 
        <td width="33%">Guest Signature<br> <br>_______________</td>      
        </tr>
		 
       
    </table>
      
        </body>
        </html>';
     // echo $html; die;
       
        $pdf->SetAutoPageBreak(FALSE);
        //$footertext = '284/9. Thiruvalluvar Street, Keelkattalai, Chennai, Tamil Nadu, India, 6000117'; 
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);  
       // $pdf->Cell(128, 85, $footertext, 0, false, 'R', 0, '', 1, false, 'T', 'M');    
        $base = Yii::$app->basePath;
       // $pdf->Output('tripslip_print.pdf');
        $fileName = 'DutySlip_'.$BookingNo.'.pdf';
        $model = TripDetails::findOne($id);
        $model->DutySlip = $fileName; 
        $model->save();

        $pdf->Output($base.'/web/uploads/DutySlip/'.$fileName, 'F');
        $pdf->Output($base.'/web/uploads/DutySlip/'.$fileName, 'I');

    }

        
}
