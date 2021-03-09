<?php



use yii\helpers\Html;





/* @var $this yii\web\View */

/* @var $model backend\models\LeftmenuManagement */



$this->title = 'Add Menu Management';

// $this->params['breadcrumbs'][] = ['label' => 'Leftmenu Managements', 'url' => ['index']];

// $this->params['breadcrumbs'][] = $this->title;

?>

<!-- <div class="leftmenu-management-create"> -->



    <?= $this->render('_form', [

        'model' => $model,

    ]) ?>



<!-- </div> -->

