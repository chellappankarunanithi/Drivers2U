<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Drivers2U - LOGIN';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
  <div class="col-sm-6">  <img src="images/logo.png"></div>
   <div class="col-sm-6">
<div class="login-box"  >


 
      <!-- /.login-logo -->
      <div class="login-box-body" style="margin-top:115px;">
        <p class="login-box-msg" style="color: #fff;">ADMIN LOGIN</p>
       <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
         
           <?= $form->field($model, 'username',[
           'options'=>[
             		'tag'=>'div',
             		'class'=>'form-group has-feedback',
             ],
			'template' => '{input}<span class="glyphicon glyphicon-envelope form-control-feedback"></span>{hint}{error}'
			])->textInput(array('placeholder' => 'Username'));  ?> 
			
			<?= $form->field($model, 'password',[
           'options'=>[
             		'tag'=>'div',
             		'class'=>'form-group has-feedback',
             ],
			'template' => '{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>{hint}{error}'])->passwordInput(array('placeholder' => 'Password'));  ?> 
			           
          
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label style="color: #fff;">
                  <?php //echo $form->field($model, 'rememberMe')-> checkbox(['value' => false]) ?> 
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
               <?= Html::submitButton('<i class="fa fa-fw fa-sign-in"></i> Login', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div><!-- /.col -->
          </div>
        <?php ActiveForm::end(); ?>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
     </div>
   </div>
      