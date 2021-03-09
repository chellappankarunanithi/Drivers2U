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





/*$auth_project = LeftmenuManagement::find()->where(['activeStatus'=>'A'])->andWhere(['IN','menuTpe',array('group','menu')])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();





$identify = ArrayHelper::index(LeftmenuManagement::find()->where(['activeStatus'=>'A'])->andWhere(['IN','menuTpe',array('group','menu')])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all(),'menuId');
*/


?>





<?php $form = ActiveForm::begin(); ?>

<div class="page-header">

    <h4 class="page-title">Left Menu Management</h4>

    <ol class="breadcrumb">

        <li class="breadcrumb-item"><?= Html::a('Left Menu Management', ['index'], ['class' => '' ]) ?></li>

        <li class="breadcrumb-item active" aria-current="page">Left Menu Management Form</li>

    </ol>

</div>



<div class="row">

      <div class="col-md-12">

          <div class="card  ">

   <?php $form = ActiveForm::begin(); ?>

              <div class="card-header">

                <?= Html::a('<i class="fa fa-arrow-left"></i> Back', Yii::$app->request->referrer, ['class' => 'btn btn-info btn-xs text-white','data-provide' =>'tooltip','data-placement'=>'top','title'=>true,'data-original-title'=>'Back to Grid']) ?>



                <?=Html::submitButton('Update Order', ['class' => 'btn btn-xs btn-primary','name'=>'Ordering','value'=>'identify'])?>



              </div>

              <div class="card-body">







<table class="table table-bordered table-striped manage" >

  <thead class="thead-dark">

    <tr>

      <th scope="col">S.NO</th>

      <th scope="col">Menu Name</th>

      <th scope="col">Menu Type</th>

      <th scope="col">Menu Order</th>

    </tr>

  </thead>

  <tbody class="fields process" id="recipeTableBody">

    <?php

      $display_data='';  

      if(!empty($model))

      {

        $s_no=1;   

        foreach ($model as $key_identify => $value) 

        {
          $display_data.='<tr class="drag-handler">';

          $display_data.='<td>'.$s_no.' </td>';

          $display_data.='<td>'.$value->Name.' </td>';

          $display_data.='<td>'.$value->menuTpe.' </td>';

          $display_data.='<td>'.$value->sortOrder.' <input type="hidden" name="MenuManagement[menuId][]" value="'.$value['menuId'].'"/> </td>';
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