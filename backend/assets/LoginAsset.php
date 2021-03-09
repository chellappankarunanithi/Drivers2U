<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'bootstrap/css/bootstrap.min.css',
        'bootstrap/css/font-awesome.min.css',
        'bootstrap/css/ionicons.min.css',
        'dist/css/AdminLTE.min.css',
        'dist/css/skins/_all-skins.min.css',
        'plugins/iCheck/flat/blue.css',
        'plugins/morris/morris.css',
        'plugins/jvectormap/jquery-jvectormap-1.2.2.css',
        'plugins/datepicker/datepicker3.css',
        'plugins/daterangepicker/daterangepicker-bs3.css',
        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',        
    ];
    public $js = [   		
   		'bootstrap/js/bootstrap.min.js',
   		'plugins/sparkline/jquery.sparkline.min.js',
   		'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
   		'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
   		'plugins/datepicker/moment.min.js',
   		'plugins/daterangepicker/daterangepicker.js',
   		'plugins/datepicker/bootstrap-datepicker.js',
   		'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
   		'plugins/slimScroll/jquery.slimscroll.min.js',
   		'plugins/fastclick/fastclick.min.js',
   		'dist/js/app.min.js',
   		'dist/js/pages/dashboard.js',
   		'dist/js/demo.js',		
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
