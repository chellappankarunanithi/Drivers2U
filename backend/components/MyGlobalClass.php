<?php 
namespace backend\components; 
use Yii;
use yii\helpers\Html;
class MyGlobalClass extends \yii\base\Component{
    public function init() {
   /* require  "../../vendor/guzzle/guzzle.phar";
    require  "../../vendor/bugsnag/utility/bugsnag.phar";
      $bugsnag = \Bugsnag\Client::make('715d69a81cdd465e94c58748d7d0c527');
          //$bugsnag->notifyException(new \RuntimeException("Test errordddddddddd"));
       //  \Bugsnag\Handler::registerWithPrevious($bugsnag);
        \Bugsnag\Handler::register($bugsnag);
        */
        $session=Yii::$app->session;
      $request = Yii::$app->request;
        
        $s_G=$_SERVER['QUERY_STRING'];
        $s_G=trim($s_G); 
 
        $get_array=explode('/', $_SERVER['REQUEST_URI']);
        $get_uri=end($get_array);

      if( $get_uri!="" && $get_uri != 'home' &&  $get_uri != 'index' &&  $get_uri != 'logout'  && $session['user_id'] == ''){
        $session['user_id']="";
        echo '<center><div style="border:#999999 solid 2px;;width:25%;">';
        
        echo "</br>";
        echo '<a>'
                      . Html::beginForm(['/site/login'], 'post')
                      . Html::submitButton(
                          '<span>Go To Login Page</span> <i class="fa fa-fw fa-sign-out"></i> ',
                          ['class' => 'button']
                      )
                      . Html::endForm()
                      . '</a>';
            
            echo "<span style='font-size:16px;font-weight:bold;'>You're being timed out due to inactivity.<br>Otherwise,You will logged off automatically.</span>";
                      echo "<br>";
             echo "<br>";
            //echo "<span style='font-size:12px;'>© ".date('Y')." Rucsan Technologies and Consulting.<br><br>";
            echo '</div><center>';
echo '<style>
.button {
  border-radius: 4px;
  background-color: #ff8600;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 18px;
  padding: 6px;
  width: 200px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: "\00bb";
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
</style>';
                     $session->destroy();   
      die;
      }else{

      }

        parent::init();
    }
    

 

}
 ?>