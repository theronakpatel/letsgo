<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

$this->title = 'Country Management';
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
                        Country List
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

                       <?php Pjax::begin(); ?> 
                       <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'name',
                                'shortcode',
                                [
                                    'attribute' => 'name',
                                    'format' => 'raw',
                                    'label' => 'Icon',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'headerOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        $icon = Yii::$app->params['uploadURL'] . 'countries/flags/flag-of-' .$model->name.'.jpg';
                                        return  "<img height='20' src='".$icon."'/>";
                                    },
                                ],
                                // ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
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

        