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
 	
 	<div class="col-md-3">
        <a href="customer">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon tar"><?=$user_count ?></span>
            <div class="mini-stat-info">
            	<div style="padding: 3px;"></div>
                <span>Customers</span> 
            </div>
        </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="category">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon tar"><?=$category_count ?></span>
            <div class="mini-stat-info">
            	<div style="padding: 3px;"></div>
                <span>Categories</span> 
            </div>
        </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="posts">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon tar"><?=$posts_count ?></span>
            <div class="mini-stat-info">
                <div style="padding: 3px;"></div>
                <span>Posts</span>
            </div>
        </div>
        </a>
    </div> 
    <div class="col-md-3">
        <a href="promotion">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon tar"><?=$promotion_count ?></span>
            <div class="mini-stat-info">
                <div style="padding: 3px;"></div>
                <span>Promotions</span>
            </div>
        </div>
        </a>
    </div> 
    <div class="col-md-3">
        <a href="merch-promotion">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon tar"><?=$merch_promotion_count ?></span>
            <div class="mini-stat-info">
                <div style="padding: 3px;"></div>
                <span>Merchant Promotions</span>
            </div>
        </div>
        </a>
    </div> 
    <div class="col-md-3">
        <a href="customer/activation">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon tar"><?=$activation_count ?></span>
            <div class="mini-stat-info">
                <div style="padding: 3px;"></div>
                <span>Customer Activation</span>
            </div>
        </div>
        </a>
    </div> 
    <div class="col-md-3">
        <a href="customer/merch-activation">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon tar"><?=$merch_activation_count ?></span>
            <div class="mini-stat-info">
                <div style="padding: 3px;"></div>
                <span>Merchantcode Activation</span>
            </div>
        </div>
        </a>
    </div> 
    <div class="row">
        <div class="col-md-3">
            <a href="customer/customnotification">
            <div class="mini-stat clearfix">
                <div class="mini-stat-info">
                	<div style="padding: 8px;"></div>
                    <span>Send Custom Notification</span>
                </div>
            </div>
            </a>
        </div>
    </div> 
</div>

