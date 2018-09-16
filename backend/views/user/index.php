7<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Management';
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
                        User Management
                        <div style="float:right">
                        
                          <a class="btn btn-success" href="<?=$bUrl ?>user/create"><i class="fa fa-plus m-right-xs"></i> Add new</a>

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
                              // 'clientOptions' => [
                              //     'type' => "POST",
                              // ],
                          ]);


                            echo GridView::widget([
                                'id' => 'kv-grid-demo',
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
                                // ['class' => 'yii\grid\SerialColumn'],
                                        [ 'class' => 'kartik\grid\SerialColumn'],                                 
                                        'name',
                                        'phone',
                                        [
                                            'label' => 'Device',
                                            'format' => 'raw',
                                            'attribute' => 'device',
                                            'value' => function ($data) { 
                                                return  ($data['device'] == '')?'-': '<span>'.strtoupper($data['device']).' <a href="#" style="color:#8BC34A;font-weight:800" class="reset_device" data-id="'.$data['user_id'].'">[Reset]</a></span>' ;

                                            }
                                        ],

                                        'email',
                                       [
                                            'label' => 'Status',
                                            'format' => 'raw',
                                            'attribute' => 'status',
                                            'filter' =>[ 'A' => 'Active', 'I' => 'Inactive', 'ENV' => 'Email not verified'],
            //                                'header' => 'Status',
                                            'value' => function ($data) { 
                                                return Html::activeDropDownList($data,  'status', [ 'A' => 'Active', 'I' => 'Inactive', 'ENV' => 'Email not verified'],['class'=>'form-control changedAdmin', 'data-id' => $data['user_id']]);

                                            }
                                        ],
                                    
                                        [
                                            'header'=>'Actions',
                                            'class' => 'yii\grid\ActionColumn',
                                            'contentOptions' => ['style' => 'max-width:50px !important;'],
                                            'headerOptions' => ['style' => 'max-width:50px !important;'],
                                        ],
                                    ],
                                // 'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
                                // 'headerRowOptions'=>['class'=>'kartik-sheet-style'],
                                // 'filterRowOptions'=>['class'=>'kartik-sheet-style'],
                                // 'pjax'=>true,
                                // 'toolbar'=> [
                                //     '{export}',
                                // ],
                                // 'panel'=>[
                                //     'type'=>GridView::TYPE_DEFAULT,
                                // ],
                                // 'persistResize'=>false,
                                // 'autoXlFormat'=>true,
                                // 'export'=>[
                                //     'fontAwesome'=>true,
                                //     'showConfirmAlert'=>false,
                                //     'target'=>GridView::TARGET_BLANK
                                // ],

                                // 'exportConfig'=>$exportConfig,
                            ]);

                        ?>
                            
                      <?php //echo GridView::widget([
                        //     'id' => 'kv-grid-demo',
                        //     'dataProvider' => $dataProvider,
                        //     'filterModel' => $searchModel,
                        //     'columns' => [
                        //         // ['class' => 'yii\grid\SerialColumn'],
                        //         [ 'class' => 'kartik\grid\SerialColumn'],                                 
                        //         'name',
                        //         'phone',
                        //         'city',
                        //         ['header'=>'Actions','class' => 'yii\grid\ActionColumn'],
                        //     ],
                        // ]); 
                        
                        ?>
			  <?php /*$this->registerJs('$("body").on("keyup.yiiGridView", "#w0 .filters input", function(){
                                $("#w0").yiiGridView("applyFilter");
                            })');*/ ?>
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

        

        
<?php
$url_ = $bUrl.'user/resetdevice';

$this->registerJs("

           $(document).on('click','.reset_device',function(e){
                e.preventDefault();
                
                var user_id = $(this).attr('data-id');
                var txt;
                var r = confirm('Are you sure you want to reset device for this user!');
                if (r == true) {
                   $.ajax({
                      url: '".$url_ ."',
                      type: 'post',
                      data: {'user_id': user_id},
                      success:function(data){ 
                        window.location.href = window.location.href;
                      },
                   });
                }  

                

            });

", \yii\web\View::POS_READY);