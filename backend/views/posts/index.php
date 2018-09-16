<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

$this->title = 'Posts Management';
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
                        Posts List
                        <div style="float:right">
                          <a class="btn btn-success" href="<?=$bUrl ?>posts/create"><i class="fa fa-plus m-right-xs"></i> Add New</a>
                         </div>
                    </header>
                    <div class="panel-body">
                     <?php if(Yii::$app->getSession()->getFlash('success') != ''){ ?>
                      <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                          <div class="alert alert-success alert-dismissible fade in" role="alert" id="messages">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <?= Yii::$app->getSession()->getFlash('success') ; ?>
                          </div>
                          </div>
                      <?php } ?>
                      <div class="col-md-12 col-sm-12 col-xs-12 no-padding" id="message_here" style="display: none">
                          <div class="alert alert-success alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                              Status update successfully
                          </div>
                      </div>
                        
                        <section id="unseen">

                        <?php 

                         Pjax::begin([
                              'timeout' => 10000,
                              'id' => 'products-container',
                          ]);
                         
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'category_name',
                                'name',
                                'description',
                                'address',
                                'latitude',
                                'longitude',
                                // 'image',
                                // 'added_date',
                                [
                                            'header'=>'Actions',
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{update} {delete}',
                                            'contentOptions' => ['style' => 'max-width:50px !important;'],
                                            'headerOptions' => ['style' => 'max-width:50px !important;'],
                                ],
                            ],
                        ]);
                        ?>
                      <?php Pjax::end(); ?>
                        </section>
                    </div>
                </section>
                
            </div>
        </div>
        <!-- page end-->
        </section>
    </section>
    <!--main content end-->

        