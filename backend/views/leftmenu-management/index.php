<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LeftmenuManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- <div class="leftmenu-management-index"> -->

<br>
<div class="row">
   <div class="col-md-12 col-lg-12">
        <div class="panel">
            <div class="panel-header" >
			<h3 class="panel-title">Menu Management</h3>
		          <div class="panel-options">
                <?= Html::a('<i class="fa fa-refresh"></i> Refresh', ['index'], ['class' => 'btn btn-outline-primary btn-sm  ' ]) ?>
                <?= Html::a('<i class="fa fa-plus"></i> Add', ['create'], ['class' => 'btn btn-primary btn-sm ml-2 mr-2 ' ]) ?>
				</div>                 
            </div>
        
            <div class="panel-body">
                <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            // 'menuFor',
                            [
                                'attribute' => 'menuFor',
                                'value' => function($models, $keys){
                                    return ucfirst($models->menuFor);
                                },
                                'filter'=>array('admin'=>'Admin','merchant'=>'Merchant'),
                            ],
                            [
                                'attribute'=>'menuTpe',
                                'value'=>function($models, $keys){
                                    return ucfirst($models->menuTpe);
                                },
                                // 'filter'=>array('menu'=>'Menu','submenu'=>'Submenu','group'=>'Group'),
                            ],
                            'Name',
                            // 'userUrl',
                            // 'menuTpe',
                            [
                                'attribute'=>'activeStatus',
                                'value'=>function($models, $keys){
                                    if($models->activeStatus=="A"){
                                        return  "Active";
                                    }else{
                                        return  "In Active";
                                    }    
                                },
                                // 'filter'=>array('1'=>'Active','0'=>'In-Active'),
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header'=> 'Action',
                                'template'=>'{update}{edit}{delete}',
                                'headerOptions' => ['style' => 'width:90px;color:#337ab7;text-align:center;'],
                                'buttons'=>[

                                    'delete' => function ($url, $model, $key) { 
                                        $sts = $model->activeStatus;
                                        $ar = array('I'=>'Active','A'=>'In Active');
                                        $ar_tog = array('A'=>'fa fa-check-circle-o fa-lg text-success','I'=>'fa fa-ban fa-lg text-danger');
                                        $title=$ar[$sts]; 
                                        $session = Yii::$app->session; 
                                        $url=Url::base().'/menu-mng-d/'.$model->menuId;
                                        $controler_url_id = Yii::$app -> controller -> id;
                                        return  Html::button('<i class="'.$ar_tog[$sts].'"></i>', ['value' => $url, 'class' => 'btn btn-outline-primary btn-sm delete gridbtncustom modalStatusChange', 'data-toggle'=>'tooltip', 'title' =>$title ]).'</div>';                                            
                                        
                                        // return Html::button('<i class="'.$ar_tog[$sts].'"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm delete gridbtncustom modalStatusChange', 'data-toggle'=>'tooltip', 'title' =>$title ]);                                            
                                    },
                                    'update' => function ($url, $model, $key) {
                                        $url=Url::base()."/menu-mng-u/".$model->menuId;
                                        $options = array_merge([
                                            'class' => 'btn btn-blue btn-sm update gridbtncustom',
                                            'data-provide' =>'tooltip','data-placement'=>'top','title'=>true,'data-original-title'=>'Update',
                                                
                                            'aria-label' => Yii::t('yii', 'Update'),
                                            'data-pjax' => '0',
                                            'data-toggle'=>'tooltip', 'title' =>'Update'
                                        ]);
                                        $session = Yii::$app->session;
                                        // echo $session['user_type'];die;
                                        if($session['user_type']=='S'){
                                            return '<div class="btn-group mb-1"> '. Html::a('<span class="fa fa-edit"></span>', $url, $options);
                                        }
                                   
                                        // return Html::a('<span class="fa fa-edit"></span>', $url, $options);
                                    },
                                    'edit' => function ($url, $model, $key) {
                                        $url=Url::base()."/menu-mng-e/".$model->menuId;
                                        $options = array_merge([
                                            'class' => 'btn btn-warning btn-sm update gridbtncustom',
                                            'data-provide' =>'tooltip','data-placement'=>'top','title'=>true,'data-original-title'=>'Update',
                                                
                                            'aria-label' => Yii::t('yii', 'Update'),
                                            'data-pjax' => '0',
                                            'data-toggle'=>'tooltip', 'title' =>'Update'
                                        ]);
                                   
                                        return Html::a('<span class="fa fa-edit"></span>', $url, $options);
                                        // return Html::a('<span class="fa fa-edit"></span>', $url, $options);
                                    },
                                ]
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
       
<!-- </div> -->

 
   

