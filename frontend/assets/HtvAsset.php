<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Solaipandian <solaipandian.istrides@gmail.com>
 * @since 2.0
 */

class HtvAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
   		'frontend/web/solnwizfiles/css/style.css',    
        'frontend/web/solnwizfiles/css/main.css',    
        'frontend/web/solnwizfiles/css/custom.css',
       // 'frontend/web/solnwizfiles/css/html.css',
        'frontend/web/solnwizfiles/css/bootstrap.css',
        'frontend/web/solnwizfiles/css/bootstrap.min.css',
        'frontend/web/solnwizfiles/css/bootstrap.min.css.map',
        'frontend/web/solnwizfiles/css/dchart.css',
         'frontend/web/solnwizfiles/css/manual.css',
        //'frontend/web/solnwizfiles/css/solnwiz_custom.css',
      
    ];
    public $js = [
    //    	'frontend/web/solnwizfiles/js/jquery-1.11.3.min.js',
        'frontend/web/solnwizfiles/js/bootstrap.js',
        'frontend/web/solnwizfiles/js/modernizr.custom.js',
        'frontend/web/solnwizfiles/js/plugins/rating/star-rating.js',
        'frontend/web/solnwizfiles/js/plugins/countto/jquery.countTo.js',
        'frontend/web/solnwizfiles/js/plugins/countto/jquery.appear.js',
        'frontend/web/solnwizfiles/js/plugins/owl/owl.carousel.js',
        'frontend/web/solnwizfiles/js/plugins/revel/jquery.themepunch.tools.min.js',
        'frontend/web/solnwizfiles/js/plugins/revel/jquery.themepunch.revolution.min.js',
        'frontend/web/solnwizfiles/js/plugins/revel/revolution.extension.actions.min.js',
        'frontend/web/solnwizfiles/js/plugins/revel/revolution.extension.layeranimation.min.js',
        'frontend/web/solnwizfiles/js/plugins/revel/revolution.extension.navigation.min.js',
        'frontend/web/solnwizfiles/js/plugins/revel/revolution.extension.parallax.min.js',
        'frontend/web/solnwizfiles/js/plugins/revel/revolution.extension.slideanims.min.js',
        'frontend/web/solnwizfiles/js/jquery.mixitup.js',
        'frontend/web/solnwizfiles/js/plugins/fancybox/jquery.fancybox.js',
        'frontend/web/solnwizfiles/js/plugins/fancybox/jquery.fancybox.pack.js',
        'frontend/web/solnwizfiles/js/plugins/bootstrap-slider/bootstrap-slider.js',
        'frontend/web/solnwizfiles/js/plugins/offcanvasmenu/snap.svg-min.js',
        'frontend/web/solnwizfiles/js/plugins/offcanvasmenu/classie.js',
       // 'frontend/web/solnwizfiles/js/plugins/offcanvasmenu/main3.js',
        'frontend/web/solnwizfiles/js/plugins/jquery-ui/jquery-ui.js',
        'frontend/web/solnwizfiles/js/plugins/c3_chart/d3.v3.min.js',
        'frontend/web/solnwizfiles/js/plugins/c3_chart/c3.js',
        'frontend/web/solnwizfiles/js/pgwslideshow.js',
        'frontend/web/solnwizfiles/js/dchart.js',
        'frontend/web/solnwizfiles/js/bootstrap.js',
        'frontend/web/solnwizfiles/js/bootstrap.min.js',
        'frontend/web/solnwizfiles/js/custom.js',
       // 'frontend/web/solnwizfiles/js/unitegallery.min.js',
        //'frontend/web/solnwizfiles/js/ug-theme-compact.js',
        'frontend/web/solnwizfiles/js/bjqs-1.3.js',
        'frontend/web/solnwizfiles/js/bjqs-1.3.min.js',
      // 'frontend/web/solnwizfiles/js/dashboard2.js',
        //'frontend/web/solnwizfiles/js/gmaps.js',
        //'frontend/web/solnwizfiles/js/npm.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
