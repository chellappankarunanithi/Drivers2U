<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

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
        
		'frontend/web/plugins/bootstrap/css/bootstrap.css',
		'frontend/web/plugins/node-waves/waves.css',
		'frontend/web/plugins/animate-css/animate.css',
		'frontend/web/css/style.css'
    ];
    public $js = [   		
   		
		//'tansi/plugins/jquery/jquery.min.js',
		'frontend/web/plugins/bootstrap/js/bootstrap.js',
		'frontend/web/plugins/node-waves/waves.js',
		'frontend/web/plugins/jquery-validation/jquery.validate.js',
		'frontend/web/js/admin.js',
		'frontend/web/js/pages/examples/sign-in.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
