<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$asset = backend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl.'/';

/* @var $this yii\web\View */
/* @var $model frontend\models\PolyUser */
$bUrl = Yii::$app->homeUrl;
$this->title = 'Update Home';
$this->params['breadcrumbs'][] = ['label' => 'Home', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';

$selected_tours_banner = array_column_udf($home_tour_banner, 'tour_id');
$seelcted_locations_poi = array_column_udf($home_tour_poi, 'location_id');
$selected_tours_walks = array_column_udf($home_tour_walks, 'tour_id');
$selected_tours_packages = array_column_udf($home_tour_package, 'package_id');
// echo "<pre>";print_r($selected_tours_walks);die;
 function array_column_udf(array $input, $columnKey, $indexKey = null) {
      $array = array();
      foreach ($input as $value) {
          if ( !array_key_exists($columnKey, $value)) {
              trigger_error("Key \"$columnKey\" does not exist in array");
              return false;
          }
          if (is_null($indexKey)) {
              $array[] = $value[$columnKey];
          }
          else {
              if ( !array_key_exists($indexKey, $value)) {
                  trigger_error("Key \"$indexKey\" does not exist in array");
                  return false;
              }
              if ( ! is_scalar($value[$indexKey])) {
                  trigger_error("Key \"$indexKey\" does not contain scalar value");
                  return false;
              }
              $array[$value[$indexKey]] = $value[$columnKey];
          }
      }
      return $array;
  }
?>


<style>
     
    .connected {
      padding: 0;
      width: 310px;
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      background: #fafafa;
      border: 1px dashed;
      position: initial !important;
    }
    .connected li{
      list-style: none;
      border: 1px solid #CCC;
      background: #F6F6F6;
      font-family: "Tahoma";
      color: #1C94C4;
      margin: 5px;
      padding: 5px;
      cursor: move;
    }
    .handles span {
      cursor: move;
    }
    li.disabled {
      opacity: 0.5;
    }
    .sortable.grid li {
      line-height: 80px;
      float: left;
      width: 80px;
      height: 80px;
      text-align: center;
    }
    li.highlight {
      background: #FEE25F;
    }
    #connected {
      /*width: 50%;*/
      overflow: hidden;
      /*margin: auto;*/
    }
    .connected {
      /*float: left;*/
      /*width: 45%;*/
      height: 400px;
      overflow: auto;
    }
    .connected.no2 {
      /*float: right;*/
    }
    li.sortable-placeholder {
      border: 1px dashed #CCC;
      background: none;
    }
    .selectedlist {
      background-color: rgba(220, 117, 43, 0.38);
      min-height: 200px;
      border: 1px dashed;
    }
    .selectedlist li {
        color: #f47421 !important;
        border-color: #f47421 !important;
    }
  </style>
<section id="main-content">
    <section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Update <b>Home Page</b> 
                </header>

                <div class="panel-body">
                  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
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
                      <div class="col-lg-12">
                         <?= $form->field($home_page_meta, 'title')->textInput(['autofocus'=>'true','placeholder'=>'Enter Page Title'])->label('Page Title (30+ characters)') ?>
                      </div>
                      <div class="col-lg-12">
                         <?= $form->field($home_page_meta, 'meta_keyword')->textInput(['placeholder'=>'Meta Keyword here'])->label('Meta Keywords (minimum 5+ keywords)') ?>
                      </div>
                      <div class="col-lg-12">
                          <?= $form->field($home_page_meta, 'meta_description')->textArea([  'placeholder' => 'Meta Description here'])->label('Meta Description (160+ characters)') ?>
                      </div>
                  </div>

                  <div class="col-lg-12 padding0">
                    <div class="col-lg-4 padding0">
                      <h3>
                        <img src="<?=$baseUrl ?>images/icons/1by1.png" width="30px">
                        Home Page Banner section</h3>
                    </div>
                    <div class="col-lg-4 padding0">
                      <h3>Selected banners</h3>
                    </div>
                  
                  <section id="connected" class="col-lg-12 padding0">
                    <ul class="connected bannerconnection list unselectedlist col-lg-4 padding0">
                      <?php foreach ($all_tours as $key => $value) { 
                        if(!in_array($value['tour_id'], $selected_tours_banner)){
                        ?>
                        <li>
                          <?=$value['tour_name'] ?> <a class="" href="<?=$bUrl ?>walks/detail?id=<?=$value['tour_id'] ?>"><i class="fa fa-pencil"></i></a>
                          <?php echo  $form->field($home_tour_banner_model, 'tour_id[]')->hiddenInput(['value' => $value['tour_id'] ,'disabled' => 'disabled' ])->label(false) ?>
                          
                      </li>
                      <?php } } ?>
                    </ul>
                     <div class="col-lg-1 padding0 dropthere">Drag <i class="fa fa-hand-o-right" aria-hidden="true"></i></div>
                      <ul class="connected bannerconnection list no2 selectedlist col-lg-4 padding0">
                      <?php foreach ($home_tour_banner as $key => $value) { ?>
                      <li><?=$value['tour_name'] ?> <a class="" href="<?=$bUrl ?>walks/detail?id=<?=$value['tour_id'] ?>"><i class="fa fa-pencil"></i></a><?php echo  $form->field($home_tour_banner_model, 'tour_id[]')->hiddenInput(['value' => $value['tour_id'] ])->label(false) ?></li>
                      <?php } ?>
                      </ul>
                     
                  </section>
                  </div>
                  <hr>
                  <input type="hidden" name="submittion" value="1">

                  <div class="col-lg-12 padding0">
                    <div class="col-lg-4 padding0">
                      <h3><img src="<?=$baseUrl ?>images/icons/2by2.png" width="30px">
                        Home Page Walks section</h3>
                    </div>
                    <div class="col-lg-4 padding0">
                      <h3>Selected walks</h3>
                    </div> 
                  <section id="connected" class="col-lg-12 padding0">
                    <ul class="connected walkconnection list unselectedlist col-lg-4 padding0">
                      <?php foreach ($all_tours as $key => $value) { 
                        if(!in_array($value['tour_id'], $selected_tours_walks)){
                        ?>
                        <li>
                          <?=$value['tour_name'] ?> <a class="" href="<?=$bUrl ?>walks/detail?id=<?=$value['tour_id'] ?>"><i class="fa fa-pencil"></i></a>
                          <?php echo  $form->field($home_tour_walks_model, 'tour_id[]')->hiddenInput(['value' => $value['tour_id'] ,'disabled' => 'disabled' ])->label(false) ?>
                        </li>
                      <?php }  } ?>
                    </ul>
                    <div class="col-lg-1 padding0 dropthere">Drag <i class="fa fa-hand-o-right" aria-hidden="true"></i></div>
                      <ul class="connected walkconnection list no2 selectedlist col-lg-4 padding0">
                      <?php foreach ($home_tour_walks as $key => $value) { ?>
                      <li>
                        <?=$value['tour_name'] ?> <a class="" href="<?=$bUrl ?>walks/detail?id=<?=$value['tour_id'] ?>"><i class="fa fa-pencil"></i></a>
                        <?php echo  $form->field($home_tour_walks_model, 'tour_id[]')->hiddenInput(['value' => $value['tour_id'] ])->label(false) ?>
                      </li>
                      <?php } ?>
                      </ul>
                    
                  </section>
                </div>
                  <hr>
                  <div class="col-lg-12 padding0">
                    <div class="col-lg-4 padding0">
                      <h3><img src="<?=$baseUrl ?>images/icons/4by1.jpg" width="30px">
                        Home Page Places section</h3>
                    </div>
                    <div class="col-lg-4 padding0">
                      <h3>Selected Places</h3>
                    </div> 
                  <section id="connected" class="col-lg-12 padding0">
                    <ul class="connected poisection list unselectedlist col-lg-4 padding0">
                      <?php foreach ($all_pois as $key => $value) { 
                        if(!in_array($value['location_id'], $seelcted_locations_poi)){
                        ?>
                        <li>
                          <?=$value['location_name'] ?> <a class="" href="<?=$bUrl ?>poi/detail?id=<?=$value['location_id'] ?>"><i class="fa fa-pencil"></i></a>
                          <?php echo  $form->field($home_tour_poi_model, 'location_id[]')->hiddenInput(['value' => $value['location_id'] ,'disabled' => 'disabled' ])->label(false) ?>
                        </li>
                      <?php }  } ?>
                    </ul>
                     
                     <div class="col-lg-1 padding0 dropthere">Drag <i class="fa fa-hand-o-right" aria-hidden="true"></i></div>
                      <ul class="connected poisection list no2 selectedlist col-lg-4 padding0">
                      <?php foreach ($home_tour_poi as $key => $value) { ?>
                      <li><?=$value['location_name'] ?> <a class="" href="<?=$bUrl ?>poi/detail?id=<?=$value['location_id'] ?>"><i class="fa fa-pencil"></i></a>
                      <?php echo  $form->field($home_tour_poi_model, 'location_id[]')->hiddenInput(['value' => $value['location_id'] ])->label(false) ?>
                    </li>
                      <?php } ?>
                      </ul>
                    
                  </section>
                  </div>


                    <hr>
                    
                   <div class="col-lg-12 padding0">
                    <div class="col-lg-4 padding0">
                      <h3><img src="<?=$baseUrl ?>images/icons/2by2.png" width="30px">
                        Home Page Packages section</h3>
                    </div>
                    <div class="col-lg-4 padding0">
                      <h3>Selected packages</h3>
                    </div>
 
                    <section id="connected" class="col-lg-12 padding0">
                      <ul class="connected walkconnection list unselectedlist col-lg-4 padding0">
                        <?php foreach ($all_packages as $key => $value) { 
                          if(!in_array($value['package_id'], $selected_tours_packages)){
                          ?>
                          <li>
                            <?=$value['package_name'] ?> <a class="" href="<?=$bUrl ?>package/detail?id=<?=$value['package_id'] ?>"><i class="fa fa-pencil"></i></a>
                            <?php echo  $form->field($home_tour_package_model, 'package_id[]')->hiddenInput(['value' => $value['package_id'] ,'disabled' => 'disabled' ])->label(false) ?>
                          </li>
                        <?php }  } ?>
                      </ul>
                      <div class="col-lg-1 padding0 dropthere">Drag <i class="fa fa-hand-o-right" aria-hidden="true"></i></div>
                        <ul class="connected walkconnection list no2 selectedlist col-lg-4 padding0">
                        <?php foreach ($home_tour_package as $key => $value) { ?>
                        <li>
                          <?=$value['package_name'] ?> <a class="" href="<?=$bUrl ?>package/detail?id=<?=$value['package_id'] ?>"><i class="fa fa-pencil"></i></a>
                          <?php echo  $form->field($home_tour_package_model, 'package_id[]')->hiddenInput(['value' => $value['package_id'] ])->label(false) ?>
                        </li>
                        <?php } ?>
                        </ul>
                      
                    </section>
                   </div>


                   <div class="form-group ">
                      <?= Html::submitButton( 'Update', ['class' => 'btn btn-success']) ?>
                      <a class="btn btn-default" href="<?=$bUrl ?>city">Reset </a>
                  </div>
                <?php ActiveForm::end(); ?>
                </div>
            </section>                
        </div>
    </div>
    </section>
</section>

<?php

$this->registerJs(" 
    $(function() {

      $('.bannerconnection').sortable({
        connectWith: '.bannerconnection'
      }).bind('sortupdate', function() {
        $('.bannerconnection.selectedlist input[type=\"hidden\"]').removeAttr('disabled');
        $('.bannerconnection.unselectedlist input[type=\"hidden\"]').attr('disabled','disabled');
      });
      $('.poisection').sortable({
        connectWith: '.poisection'
      }).bind('sortupdate', function() {
        $('.poisection.selectedlist input[type=\"hidden\"]').removeAttr('disabled');
        $('.poisection.unselectedlist input[type=\"hidden\"]').attr('disabled','disabled');
      });
      $('.walkconnection').sortable({
        connectWith: '.walkconnection'
      }).bind('sortupdate', function() {
        $('.walkconnection.selectedlist input[type=\"hidden\"]').removeAttr('disabled');
        $('.walkconnection.unselectedlist input[type=\"hidden\"]').attr('disabled','disabled');
      });

    });

", \yii\web\View::POS_READY);
?>  