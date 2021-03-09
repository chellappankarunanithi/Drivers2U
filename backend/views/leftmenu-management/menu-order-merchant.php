<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\models\leftmenuManagement;
/* @var $this yii\web\View */
/* @var $model backend\models\AuthProjectModule */
/* @var $form yii\widgets\ActiveForm */
//$auth_project_module=AuthProjectModule::find()->asArray()->all();

//$rt=count($auth_project_module)+1;
$this->title = 'Menu Order Management';


$auth_project = LeftmenuManagement::find()->where(['activeStatus'=>'A'])->andWhere(['menuFor'=>'merchant'])->andWhere(['IN','menuTpe',array('group','menu')])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();


$identify = ArrayHelper::index(LeftmenuManagement::find()->where(['activeStatus'=>'A'])->andWhere(['menuFor'=>'merchant'])->andWhere(['IN','menuTpe',array('group','menu')])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all(),'menuId');

?>


<?php $form = ActiveForm::begin(); ?>
<div class="page-header">
    <h4 class="page-title">Merchant's Menu Order Management</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">#</li>
    </ol>
</div>

<div class="row">
      <div class="col-md-12">
          <div class="card  ">

   <?php $form = ActiveForm::begin(); ?>
              <div class="card-header">
              
                <?= Html::a(' Admin Menu Order <i class="fa fa-arrow-right"></i>', ['menu-order'], ['class' => 'btn btn-primary btn-sm ml-2 mr-2 ' ]) ?>
              </div>
              <div class="card-body">



<table class="table table-bordered table-striped manage" >
  <thead class="thead-dark">
    <tr>
      <th scope="col">S.NO</th>
      <th scope="col">Menu Name</th>
      <th scope="col">Menu Type</th>
      <th scope="col">Menu Order</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody class="fields process" id="recipeTableBody">
    <?php
      $display_data='';  
      if(!empty($identify))
      {
        $s_no=1;   
        foreach ($identify as $key_identify => $value) 
        {
          $a_tag = "";
          if($value['menuTpe'] == 'group')
          {
              $url=Url::base()."/sub-menu-order-merchant/".$value['menuId'];
              $a_tag =  Html::a('Sub-Menu <i class="fa fa-arrow-right"></i>',$url , ['class' => 'btn btn-success btn-sm  ' ]);
          }

          $display_data.='<tr class="drag-handler">';
          $display_data.='<td>'.$s_no.' </td>';
          $display_data.='<td>'.$value['Name'].' </td>';
          $display_data.='<td>'.$value['menuTpe'].' </td>';
          $display_data.='<td>'.$value['sortOrder'].' <input type="hidden" name="MenuManagement[menuId][]" value="'.$value['menuId'].'"/> </td>';
          $display_data.='<td>'.$a_tag.'</td>';  
          $display_data.='</tr>';
          $s_no++;
        } 
      }

   echo $display_data;
    ?>
  </tbody>
</table>

                
              
    
              </div>
  <div class="card-footer">
         <div class="text-right">
                      <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-square']) ?>
                  </div>
                  
    </div>
    <?php ActiveForm::end(); ?>
          </div>
      </div>
  </div>

<script>
  
  $(document).ready(function () {
    
    Sortable.create(
        $('#recipeTableBody')[0], {
         animation: 150,
            scroll: true,
       onDragClass: "myDragClass",
            handle: '.drag-handler',
            //onEnd: function () {
               // console.log('More see in https://github.com/RubaXa/Sortable');
           // }
        }
    );
});
  </script>