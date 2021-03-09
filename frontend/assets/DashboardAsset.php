<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DashboardAsset extends AssetBundle
{
     public function init() {
        $this->jsOptions['position'] = View::POS_BEGIN;
        parent::init();
    }
  
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    "frontend/web/plugins/bootstrap/css/bootstrap.css",
    "frontend/web/plugins/node-waves/waves.css",
    "frontend/web/plugins/animate-css/animate.css",
    "frontend/web/plugins/material-design-preloader/md-preloader.css",
    "frontend/web/plugins/morrisjs/morris.css" ,
    "frontend/web/dist/css/style.css",
    "frontend/web/dist/css/themes/all-themes.css",
    ];
    public $js = [
     "frontend/web/plugins/bootstrap/js/bootstrap.js",
   
    "frontend/web/plugins/bootstrap-select/js/bootstrap-select.js",
    "frontend/web/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js",
    "frontend/web/plugins/node-waves/waves.js",
    "frontend/web/plugins/raphael/raphael.min.js",
    "frontend/web/plugins/morrisjs/morris.js",
   "frontend/web/plugins/jquery/jquery.js",
  //"frontend/web/plugins/jquery/jquery.min.js",
    "frontend/web/plugins/jquery-sparkline/jquery.sparkline.js",
    "frontend/web/dist/js/admin.js",
    "frontend/web/dist/js/pages/index.js",
    "frontend/web/dist/js/demo.js",
     "frontend/web/plugins/jquery-slimscroll/jquery.slimscroll.js",
    /*"frontend/web/plugins/jquery/jquery.min.js",
    "frontend/web/plugins/flot-charts/jquery.js",
    "frontend/web/plugins/bootstrap/js/bootstrap.js",
    "frontend/web/plugins/bootstrap-select/js/bootstrap-select.js",
    "frontend/web/plugins/jquery-slimscroll/jquery.slimscroll.js",
    "frontend/web/plugins/bootstrap-notify/bootstrap-notify.js", 
    "frontend/web/plugins/node-waves/waves.js",
    "frontend/web/dist/js/admin.js",*/
    
	//"frontend/web/plugins/jquery/jquery.min.js",
	 //"plugins/jquery/jquery.js",
   
   /*
    "frontend/web/plugins/jquery-countto/jquery.countTo.js",   
    "frontend/web/plugins/raphael/raphael.min.js",
    "frontend/web/plugins/morrisjs/morris.js",*/
    /*
      
    "frontend/web/plugins/jquery-sparkline/jquery.sparkline.js",
    
    "frontend/web/dist/js/pages/index.js",
    "frontend/web/dist/js/demo.js",*/
    ];
  
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
