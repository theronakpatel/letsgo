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
class AppAsset extends AssetBundle
{
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    public $sourcePath = '@bower/bucketadmin4/';
    public $css = [
        "bs3/css/bootstrap.min.css",
        "js/jquery-ui/jquery-ui-1.10.1.custom.min.css",
        "css/bootstrap-reset.css",
        "font-awesome/css/font-awesome.css",
        "js/jvector-map/jquery-jvectormap-1.2.2.css",
        "css/clndr.css",
        "js/css3clock/css/style.css",
        "js/morris-chart/morris.css",
        "css/style.css",
        'js/ckeditor/samples/css/samples.css',
        // "css/orange-theme.css",
        // "css/sweetalert.css",
        "js/bootstrap-colorpicker/css/colorpicker.css",
        "js/bootstrap-datepicker/css/datepicker.css",
        "js/bootstrap-daterangepicker/daterangepicker-bs3.css",
        "js/bootstrap-datetimepicker/css/timepicki.css",
        "css/validation-engine/validationEngine.jquery.css",
        "css/style-responsive.css",
        "js/bootstrap-datetimepicker/css/datetimepicker.css",
        "css/contents.css",



    ];
    public $js = [
        //"js/jquery.js",
        "js/jquery-ui/jquery-ui-1.10.1.custom.min.js",
        "bs3/js/bootstrap.min.js",
        "js/jquery.dcjqaccordion.2.7.js",
        "js/jquery.scrollTo.min.js",
        "js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js",
        "js/jquery.nicescroll.js",
        "js/skycons/skycons.js",
        "js/jquery.scrollTo/jquery.scrollTo.js",
        "js/validation-engine/jquery.validationEngine.js",
        "js/validation-engine/jquery.validationEngine-en.js",
        "https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js",
        "js/calendar/clndr.js",
        "http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js",
        "js/calendar/moment-2.2.1.js",
        // "js/evnt.calendar.init.js",
        "js/jvector-map/jquery-jvectormap-1.2.2.min.js",
        "js/jvector-map/jquery-jvectormap-us-lcc-en.js",
        "js/gauge/gauge.js",
        "js/css3clock/js/css3clock.js",
        "js/morris-chart/morris.js",
        "js/morris-chart/raphael-min.js",
        // "js/ckeditor/ckeditor.js",
        'js/ckeditor/ckeditor.js',
        'js/ckeditor/config.js',
        'js/ckeditor/sample.js',
        "js/jquery.mask.js",

        "js/styles.js",
        "js/config.js",
        "js/ckeditor.js",
        "js/build-config.js",
/*        "js/easypiechart/jquery.easypiechart.js",
        "js/sparkline/jquery.sparkline.js",
        
        
        "js/flot-chart/jquery.flot.js",
        "js/flot-chart/jquery.flot.tooltip.min.js",
        "js/flot-chart/jquery.flot.resize.js",
        "js/flot-chart/jquery.flot.pie.resize.js",
        "js/flot-chart/jquery.flot.animator.min.js",
        "js/flot-chart/jquery.flot.growraf.js",*/
        "js/dashboard.js",
        "js/jquery.customSelect.min.js" ,
        "js/scripts.js",
        // "js/sweetalert.min.js",
        "js/bootstrap-daterangepicker/moment.min.js",
        "js/bootstrap-datepicker/js/bootstrap-datepicker.js",
        "js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
        "js/bootstrap-datetimepicker/js/timepicki.js",
        "js/bootstrap-daterangepicker/daterangepicker.js",
        "https://content.jwplatform.com/libraries/aJnVD08g.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
