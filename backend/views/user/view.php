  <?php

  use yii\helpers\Html;
  use yii\widgets\DetailView;
 
// use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;


  /* @var $this yii\web\View */
  /* @var $model frontend\models\Wifi */
  $bUrl = Yii::$app->homeUrl;
  $this->title = 'View User #'.$model->user_id;
  $this->params['breadcrumbs'][] = ['label' => 'Wifis', 'url' => ['index']];
  $this->params['breadcrumbs'][] = $this->title;
  ?>
 


  <!--main content start-->
      <section id="main-content">
    <section class="wrapper">
    <!-- page start-->

    <div class="row">
        
        
      
        <?php if(Yii::$app->getSession()->getFlash('success') != '' || Yii::$app->getSession()->getFlash('error') != ''){ ?>
          <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="alert alert-success alert-dismissible fade in" role="alert" id="messages">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <?= Yii::$app->getSession()->getFlash('success') ; ?>
        <?= Yii::$app->getSession()->getFlash('error') ; ?>
      </div>
      </div>
        <?php } ?>
      <div class="col-sm-12">    
      <section class="panel">
          <header class="panel-heading">
        <b>View User:</b> <?=$model->name ?>
        <div style="float:right">
        
      
            <a class="5px7 btn btn-success" href="<?=$bUrl ?>user/update?id=<?=$model->user_id ?>"><i class="fa fa-pencil m-right-xs"></i> Update</a>
            <!-- <a class="5px7 btn btn-danger" href="<?=$bUrl ?>tour/purchasedetails?id=<?=$model->user_id ?>"><i class="fa fa-rocket m-right-xs"></i> Purchased Tours</a>
            <a class="5px7 btn btn-danger" href="<?=$bUrl ?>transaction/transactiondetails?id=<?=$model->user_id ?>"><i class="fa fa-money m-right-xs"></i> Transactin History</a>
            <a class="5px7 btn btn-danger" href="<?=$bUrl ?>tour/sharetours?id=<?=$model->user_id ?>"><i class="fa fa-money m-right-xs"></i> Shared Tours</a> -->
            <a class="5px7 btn btn-success" href="<?=$bUrl ?>user"><i class="fa fa-reply m-right-xs"></i> Back to User List</a>

            
        </div>
          </header>
      
          <div class="panel-body">
          

        <section id="unseen">
          
       
        

          <?= DetailView::widget([
          'model' => $model,
          'attributes' => [
              'user_id',
              'name',
              'email',
              'phone',
              
  
              [
              'attribute' => 'device',
              'format'=>'raw',
              'value' => $model->device == '' ? '-' : strtoupper($model->device),

              ],   
              [
              'attribute' => 'status',
              'format'=>'raw',
              'value' => $model->status == 'A' ? 'Active' : ($model->status == 'I' ? 'Inactive' : 'Email not verified'),

              ],
              [
              'attribute' => 'access_type',
              'format'=>'raw',
              'value' => $model->access_type == '0' ? 'Live' : ($model->access_type == '1' ? 'Live+Beta' : 'Beta'),

              ],
              
          ],
            ]) ?>  


              
      
        </section>

        <section id="unseen">
			  	<label>Purchased Tours</label>
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
                                'dataProvider'=> $PurchaseddataProvider,
//                                'filterModel'=>$searchModel,
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
                                         'TourName',
                                         'device',
                                         'PurchasedDate',
                                         'expiry_date',
                                         // 'payment_id',
                                         // 'Name',
                                    
                                    
                                        // ['header'=>'Actions','class' => 'yii\grid\ActionColumn'],
                                    ],
                        
                            ]);

                        ?>
                            
                  <?php Pjax::end(); ?> 


      
			  </section>



                        <section id="unseen">
<label>Shared Tours</label>

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
                                'dataProvider'=>$sharedDataProvider,
//                                 'filterModel'=>$searchModel,
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
                                         'TourName',
                                         // 'Name',
                                         'phone',
                                         'created_date',
                                            
                                        
                                    
                                        // ['header'=>'Actions','class' => 'yii\grid\ActionColumn'],
                                    ],
                        
                            ]);

                        ?>
                            
                  <?php Pjax::end(); ?> 
    
                        </section>


                         <section id="unseen">
<label>Transaction History</label>

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
                                'dataProvider'=>$paymentHistorydataProvider,
                                // 'filterModel'=>$searchModel,
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
                                         // 'Name',
                                        'TourName',
                                         'amount',
                                         'transaction_id',
                                        [
//                                             'label' => 'payment_status',
                                            'format' => 'raw',
                                            'attribute' => 'payment_status',
                                            'filter' =>[ 'success' => 'Success', 'failed' => 'Failed'],
            //                                'header' => 'Status',
                                            'value' => function ($data){ 
                                                if($data['payment_status'] == 'success'){
                                                  return 'Success';
                                                }else{
                                                  return 'Failed';
                                                }
                                            }
                                        ],
                                        'created_date',
                                    
                                        // ['header'=>'Actions','class' => 'yii\grid\ActionColumn'],
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

    