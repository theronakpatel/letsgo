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
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    public $sourcePath = '@bower/bucketadmin4/';
    public $css = [
        'bs3/css/bootstrap.min.css',
        'css/bootstrap-reset.css',
        'font-awesome/css/font-awesome.css',
        'css/style.css',
        'css/style-responsive.css',
        "css/sweetalert.css",
    ];
    public $js = [
        'js/jquery.js',
        'bs3/js/bootstrap.min.js',
         "js/sweetalert.min.js"
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
