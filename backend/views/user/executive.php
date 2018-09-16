<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin List';
$this->params['breadcrumbs'][] = $this->title;
$bUrl = Yii::$app->homeUrl;

?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="row">
            <div class="page-title">
              <div class="title_left">
                <h3>Admin Management</h3>
              </div>
                  <?php if(Yii::$app->getSession()->getFlash('success') != ''){ ?>
                    <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                      <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <?= Yii::$app->getSession()->getFlash('success') ; ?>
                      </div>
                      </div>
                  <?php } ?>
             
             
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Admin List <small>List</small></h2>
                     <div style="float:right">
                    <a class="btn btn-success" href="<?=$bUrl ?>?r=poly-user/create"><i class="fa fa-plus m-right-xs"></i> Add new</a>
                    </div>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                      <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            'name',
            'phone',
            
            
                    
            [
            'attribute'=>'app_type',
            'header'=>'App Type',
            'filter' => ['W'=>'Web', 'M'=>'Mobile'],
            'format'=>'raw', 
             'value' => function($model, $key, $index)
            {   
                if($model->user_type == 'W')
                {
                    return 'Web';
                }
                else 
                {
                    return 'Mobile';
                }
            },
            
        ],
         
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->