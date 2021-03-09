<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Swim - LOGIN';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
      <div class="logo" >
        <a href="../../index2.html" target="_blank"><center> <span class="logo-mini"><img src="<?= Url::to('@web/frontend/web/images/swim_logo.png') ?>" width="220px" height="75px"> </span> </center></a> 
         <!-- <a href="../../index2.html">Admin<b>SWIM</b></a> -->
         
      </div>
      <!-- /.login-logo -->
      
      
      <div class="card">
            <div class="body">
                                <?php $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'fieldConfig' => [
                                            'template' => '<div class="form-line">{input}</div>{error}']
                                ]); ?>
                            <div class="msg">Sign in to start your session</div>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person</i>
                                        </span>
                                
                                          <?= $form->field($model, 'username')->textInput(array('placeholder' => 'Branch Code'));  ?> 
                                </div>
                                          
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">lock</i>
                                        </span>
                                        
                                    
                                                        
                                            
                                            <?= $form->field($model, 'password')->passwordInput(array('placeholder' => 'Password'));  ?> 
                                   
                      
                      
                                </div>
                                
                                  <div class="row">
                                    <div class="col-xs-4 p-t-5">
                      
                                    <!--<?= $form->field($model,'rememberMe')->checkbox(); ?> -->
                                   <!--  <?= $form->field($model, 'rememberMe', ['template' => "<div class=\"checkbox\">\n{input}\n{label}\n{error}\n{hint}\n</div>"])->input('checkbox',['class'=>'filled-in']);?> -->
                              
                                    </div>
                                    
                                    
                                    <div class="col-xs-4">
                            
                           <?= Html::submitButton('<i class="fa fa-fw fa-sign-in"></i> Login', ['class' => 'btn btn-primary btn-block btn-flat waves-effect', 'name' => 'login-button']) ?>
                                </div></div>
                                
                                <!--<div class="row m-t-15 m-b--20">
                                    <div class="col-xs-6">
                                        <a href="sign-up.html">Register Now!</a>
                                    </div>
                                    <div class="col-xs-6 align-right">
                                        <a href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                </div>-->
                    <?php ActiveForm::end(); ?>
                  <!-- /.login-box-body -->
      </div>
    </div><!-- /.login-box -->
    </div>