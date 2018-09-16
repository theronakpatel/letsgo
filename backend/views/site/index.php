<?php
// use app\assets\AppAsset_1;

use kartik\grid\GridView;

$this->title = 'Dashboard';

?>

<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
// use yii\bootstrap\Nav;
// use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;

$asset = backend\assets\AppAsset::register($this);
// public $basePath = '@webroot';

$bUrl = Yii::$app->homeUrl;
// print_r(Yii::$app->homeUrl);exit;

$baseUrl = $asset->baseUrl;


?>


<!--main content start-->
<section id="main-content">
<section class="wrapper">
 
  <?php if(Yii::$app->getSession()->getFlash('success') != ''){ ?>
  <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
      <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <?= Yii::$app->getSession()->getFlash('success') ; ?>
      </div>
      </div>
  <?php } ?>
  
 
<div class="row">
 	
 	
</div>

