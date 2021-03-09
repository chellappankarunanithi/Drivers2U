<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

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
        
        'bootstrap/css/bootstrap.min.css',
        'bootstrap/css/font-awesome.min.css',
        'bootstrap/css/ionicons.min.css',
        'dist/css/AdminLTE.min.css',
        'dist/css/skins/_all-skins.min.css',
        'plugins/iCheck/flat/blue.css',
        'plugins/morris/morris.css',
        'plugins/jvectormap/jquery-jvectormap-1.2.2.css',
      //  'plugins/datepicker/datepicker3.css',
        //'plugins/daterangepicker/daterangepicker-bs3.css',
       // 'plugins/timepicker/bootstrap-timepicker.min.css',
        'plugins/datetimepicker/build/css/bootstrap-datetimepicker.css',
        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
        'plugins/datatables/dataTables.bootstrap.css',
        'plugins/jQuery-Form-Wizard-Plugin-Smart-Wizard/styles/smart_wizard.css',
        'css/site.css',
        
    ];
    public $js = [   		
   		'bootstrap/js/bootstrap.min.js',
   		'plugins/sparkline/jquery.sparkline.min.js',
   		'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
   		'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
   		// 'plugins/timepicker/bootstrap-timepicker.min.js',
   		'plugins/datepicker/moment.min.js',
      'plugins/datetimepicker/build/js/bootstrap-datetimepicker.min.js',
   		//'plugins/daterangepicker/daterangepicker.js',
   		//'plugins/datepicker/bootstrap-datepicker.js',
   		'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
   		'plugins/slimScroll/jquery.slimscroll.min.js',
   		'plugins/fastclick/fastclick.min.js',
   		'dist/js/app.min.js',
   		'dist/js/demo.js',
   		'plugins/datatables/jquery.dataTables.min.js',
   		'plugins/datatables/dataTables.bootstrap.min.js',
   		'plugins/jQuery-Form-Wizard-Plugin-Smart-Wizard/js/jquery.smartWizard.js',
		
    ];
	
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
