<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

$this->title = 'Promotion Management';
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
                        Promotion List
                        <div style="float:right">
                          <a class="btn btn-success" href="<?=$bUrl ?>merch-promotion/create"><i class="fa fa-plus m-right-xs"></i> Add New</a>
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
                                'dataProvider'=>$dataProvider,
                                'filterModel'=>$searchModel,
                                 'pager' => [
                                  'options'=>['class'=>'pagination'],   // set clas name used in ui list of pagination
                                  'prevPageLabel' => '<',   // Set the label for the "previous" page button
                                  'nextPageLabel' => '>',   // Set the label for the "next" page button
                                  'firstPageLabel'=>'<<',   // Set the label for the "first" page button
                                  'lastPageLabel'=>'>>',    // Set the label for the "last" page button
                                  'nextPageCssClass'=>'next',    // Set CSS class for the "next" page button
                                  'prevPageCssClass'=>'prev',    // Set CSS class for the "previous" page button
                                  'firstPageCssClass'=>'first',    // Set CSS class for the "first" page button
                                  'lastPageCssClass'=>'last',    // Set CSS class for the "last" page button
                                  'maxButtonCount'=>3,    // Set maximum number of page buttons that can be displayed
                                  ],
                                'columns' => [
                                        'name',
                                        'description',
                                        'promotion_points',
                                        'merchant_code',
                                        [
                                            'attribute' => 'image',
                                            'format' => 'raw',
                                            'label' => 'Image',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'headerOptions' => ['class' => 'text-center'],
                                            'value' => function ($model) {
                                                return  "<img height='100' src='".Yii::$app->params['uploadURL'] . 'promotion/' . $model->image."' />";
                                            },
                                        ],
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

        