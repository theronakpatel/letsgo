<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

$this->title = 'Activation Codes';
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
                        Activation Codes
                        <div style="float:right">
                          <a class="btn btn-success" href="<?=$bUrl ?>promotion/index"><i class="fa fa-reply m-right-xs"></i> Back</a>
                         </div>
                    </header>
                    <div class="panel-body">
                     
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
                                        'activation_code',
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

        