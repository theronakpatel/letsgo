<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Add new post';
$this->params['breadcrumbs'][] = $this->title;
$bUrl = Yii::$app->homeUrl;

?>


 <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->

        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Add new post
                        <div style="float:right">
                          <a class="btn btn-success" href="<?=$bUrl ?>posts"><i class="fa fa-reply m-right-xs"></i> Back</a>
                        <!-- <a class="btn btn-danger" href="<?= Yii::$app->request->referrer; ?>"><i class="fa fa-reply m-right-xs"></i> Back</a> -->
                         </div>
                    </header>
                    <div class="panel-body">
                     <?php if(Yii::$app->getSession()->getFlash('success') != ''){ ?>
                      <div class="col-md-6 col-sm-6 col-xs-6 no-padding">
                          <div class="alert alert-success alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <?= Yii::$app->getSession()->getFlash('success') ; ?>
                          </div>
                          </div>
                      <?php } ?>

                        <section id="unseen">
                            <?= $this->render('_form', [
                              'model' => $model,
                              'categories' => $categories,
                              'multipleImages' => $multipleImages
                          ]) ?>
    
                        </section>
                    </div>
                </section>
                
            </div>
        </div>
        <!-- page end-->
        </section>
    </section>
    <!--main content end-->

