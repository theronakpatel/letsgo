<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PolyUser */
$bUrl = Yii::$app->homeUrl;
$this->title = 'Update User: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Poly Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>

 <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->

        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <b>Update User:</b> <?=$model->name ?>
                        <div style="float:right">
                              

                          <a class="btn btn-success" href="<?=$bUrl ?>user"><i class="fa fa-reply m-right-xs"></i> Back </a>

                         </div>
                    </header>
                    <div class="panel-body">
                     <?php if(Yii::$app->getSession()->getFlash('success') != ''){ ?>
                      <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
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

        