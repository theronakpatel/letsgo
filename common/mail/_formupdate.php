<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$asset = backend\assets\AppAsset::register($this);
// public $basePath = '@webroot';

$bUrl = Yii::$app->homeUrl;
$baseUrl = $asset->baseUrl;

 
/* @var $this yii\web\View */
/* @var $model frontend\models\PolyUser */
/* @var $form yii\widgets\ActiveForm */
$old_tour_total_time = explode(":", $model->tour_total_time);
$tour_total_time[0] = $old_tour_total_time[0];
$tour_total_time[1] = $old_tour_total_time[1];
$model->tour_total_time = implode(":", $tour_total_time);
?>

<div class="poly-user-form">

    <?php $form = ActiveForm::begin(); ?>

     <div class="row marbottom10">
      <div class="col-lg-12" id="note">
       <i> <b>Note</b>: File type supported : jpg,png(for image), mp3(for audio), mp4(for video)<br>
              File resolution : 2048 by 2048(max for image), 128 kbps to 320 kbps(for audio), 640 by 480 (for video)<br>
              File size : 3MB(max for image),depends on the distance between point(for audio), 20MB(max for video)
        </i>
    </div>
    </div>
    
    
 <div class="row">
      <div class="col-lg-4">
       <?= $form->field($model, 'city_id')->dropDownList($model->citylist,['prompt'=>'-Choose a City-']) ?>
      </div>
     <div class="col-lg-4">
        <?= $form->field($model, 'tour_name')->textInput(['autofocus'=>'true','maxlength' => true]) ?>
      </div>
     
      
 </div>
 <div class="row">
     <div class="col-lg-4">
        <?= $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', 'deleted' => 'Deleted', 'draft' => 'Save to Draft', 'beta' => 'Beta'], ['prompt' => '--Select--']) ?>
      </div>

       <div class="col-lg-4">
            <?= $form->field($model, 'tour_total_time')->textInput(['id'=>'tour_total_time','class'=> "form-control" ,"data-mask"=>"00:00" ,"placeholder"=>"__:__"]) ?>
      </div>

 </div>
 <div class="row">
       
      <div class="col-lg-4">
        <?= $form->field($model, 'tour_total_distance')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-lg-4">
        <?= $form->field($model, 'tour_price')->textInput(['maxlength' => true]) ?>
      </div>
    </div>


        
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'max_referral')->textInput([]) ?>
      </div>
      <div class="col-lg-4">
        <?= $form->field($model, 'max_expiry_month')->textInput([]) ?>
        
      </div>
    </div>

        
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'trip_advisor_url')->textInput([]) ?>
      </div>
       
    </div>



<div class="row">
      <div class="col-lg-4">
       <?= $form->field($model, 'language_id')->dropDownList($model->languagelist,['prompt'=>'-Choose a language-']) ?>
      </div> 
      <div class="col-lg-4 required">
       <label class="control-label" for="tour-iap_product_id">Apple Product ID</label>
      <a 
      class="btn btn-lg btn-default"
      role="button"
      tabindex="0"
      data-toggle="popover" 
      data-container="body" 
      
      data-placement="right" 
      title="How to Get Apple Product ID?"
      style="padding: 0 5px;font-size: 12px;border-radius: 50%;"
      data-content="Create product at https://itunesconnect.apple.com to get Apple Product ID.">?</a>
      <!-- data-trigger="focus"   -->
      <?= $form->field($model, 'iap_product_id')->textInput([])->label(false); ?>
      </div> 
 </div>



 <div class="row">
      <div class="col-lg-4">
        <?= $form->field($model, 'tour_tips')->textArea([]) ?>
      </div>
      <div class="col-lg-4">
        <?= $form->field($model, 'tour_description')->textArea([]) ?>
      </div>
    </div>
   
    <div class="row">
      <div class="col-lg-2">
        <label> Tour Media (Audio/Video/Images)</label>
      </div>

        <div id="tour_here" style="display:none">
            <div class="martop10 new_media_div">
                    <div class="row margin0">
                      <!-- <div class=" col-sm-2">
                        <?php // echo $form->field($mediamodel, 'media_type[]')->dropDownList(['image'=>'Image','audio'=>'Audio','video' => 'Video'])->label(false) ?>  
                      </div> -->

                      <div class="col-sm-5">
                        <?= $form->field($mediamodel, 'media_name[]')->fileInput(['autofocus'=>'true','maxlength' => true,'class' => 'tour_media_media_name validate[required,checkFileType[jpg|jpeg|gif|JPG|png|PNG|MP3|mp3|MP4|mp4]]'])->label(false) ?>
                      </div>  
                       
                      <!-- <div class="col-sm-1 ">
                        <a href="javascript:void(0)" class="btn btn-info"  title="Pick to drag and drop">
                          <i class="fa fa-arrows-v m-right-xs"></i>
                        </a>
                      </div> -->

                      <div class="col-sm-1 ">
                        <a href="javascript:void(0)" class="btn btn-danger remove_this_media">
                          <i class="fa fa-minus m-right-xs"></i>
                        </a>
                      </div>
                    </div>  
            </div> 
        </div>
      

        <div class="col-lg-10">
            <div class="row">
                    <div class="append_media_here ">
                      <div class="martop10 new_media_div">
                        <div class="row margin0">
                          <!-- <div class=" col-sm-2">
                            <?php // echo $form->field($mediamodel, 'media_type[]')->dropDownList(['image'=>'Image','audio'=>'Audio','video' => 'Video'])->label(false) ?>                    
                          </div> -->

                          <div class="col-sm-5">
                        <?= $form->field($mediamodel, 'media_name[]')->fileInput(['autofocus'=>'true','maxlength' => true,'class' => 'tour_media_media_name validate[checkFileType[jpg|jpeg|gif|JPG|png|PNG|MP3|mp3|MP4|mp4]]'])->label(false) ?>
                          </div>  

                          <!-- <div class="col-sm-1 ">
                            <a href="javascript:void(0)" class="btn btn-info"  title="Pick to drag and drop">
                              <i class="fa fa-arrows-v m-right-xs"></i>
                            </a>
                          </div> -->

                          <div class="col-sm-1 ">
                            <a href="javascript:void(0)" class="btn btn-danger remove_this_media">
                              <i class="fa fa-minus m-right-xs"></i>
                            </a>
                          </div>
                        </div>  
                      </div>  
                    </div>

                  <div class="martop10 col-sm-1">
                    <a href="javascript:void(0)" class="btn btn-success add_new_tour_media">
                      Add
                    </a>
                  </div>
            </div>
        </div>

    </div>
  
<?php if(sizeof($data)){ ?>
        <div class="col-sm-12 marbottom10 required padding0">
          <div class="panel-title">
            <b>Uploaded Media</b>
          </div> 
        </div>
    
        <div class="col-sm-10 col-sm-offset-2 marbottom10 required padding0">
        <div class="row">
        <?php 
        // print_r($data);die;
        foreach ($data as $key_tourmedia => $value_tourmedia) { 

          ?>
                <?php if($value_tourmedia['media_type'] == 'image'){ ?>
                    <div  class="col-sm-2">
                      <img src="<?=Yii::$app->params['uploadUrl'] ?>tour/media/thumb/thumb_<?= $value_tourmedia['media_name'] ?>" class="img_delete play-media-modal" data-val="<?=Yii::$app->params['uploadUrl'] ?>tour/media/<?= $value_tourmedia['media_name'] ?>" 
                      title="<?=$value_tourmedia['name'] ?>">
                      <a href="javascript:void(0)" class="btn btn-danger deleteImage_tour" data-id="<?= $value_tourmedia['media_id'] ?>" >X</a>
                      <div><?=$value_tourmedia['name'] ?></div>
                    </div>
                <?php } ?>
        <?php } ?>
        </div>
        </div>


        <div class="col-sm-10 col-sm-offset-2 marbottom10 required padding0">
          <div class="row">
        <?php foreach ($data as $key_tourmedia => $value_tourmedia) { 
          ?>

            <?php if($value_tourmedia['media_type'] == 'audio'){ ?>
                  <div  class="col-sm-2">
                    <img src="<?=$baseUrl ?>/images/music.png" height="80" width="80" class="play-media-modal" title="<?=$value_tourmedia['name'] ?>" data-type="<?=$value_tourmedia['media_type'] ?>" class="img_delete" data-val="<?=Yii::$app->params['uploadUrl'] ?>tour/media/<?= $value_tourmedia['media_name'] ?>"> 
                    <a href="javascript:void(0)" class="btn btn-danger deleteImage_tour" data-id="<?= $value_tourmedia['media_id'] ?>" >X</a>
                    <div><?=$value_tourmedia['name'] ?></div>
                  </div>
                <?php }  ?>
        <?php } ?>
        </div>
        </div>


        <div class="col-sm-10 col-sm-offset-2 marbottom10 required padding0">
          <div class="row">
        <?php foreach ($data as $key_tourmedia => $value_tourmedia) { 
          ?>
                <?php if($value_tourmedia['media_type'] == 'video'){ ?>
             
              <div  class="col-sm-2">
                <img src="<?=$baseUrl ?>/images/video.png" height="80" width="80" class="play-media-modal" title="<?=$value_tourmedia['name'] ?>" data-type="<?=$value_tourmedia['media_type'] ?>" class="img_delete" data-val="<?=Yii::$app->params['JW_videopath']."".$value_tourmedia['video_key'].".mp4" ?>"> 
                <a href="javascript:void(0)" class="btn btn-danger deleteImage_tour" data-id="<?= $value_tourmedia['media_id'] ?>" >X</a>
                <div><?=$value_tourmedia['name'] ?></div>
              </div>
            
                <?php } ?>
        <?php } ?>
        </div>
        </div>

        <?php } ?>
    <div class="col-lg-12 martop10">
          <label> Add Points</label>
    </div>
       <div  class="martop10" id="append_here">
          <?php foreach ($point_model as $key_point => $value_point){ ?>
                <!-- Pointof interest start -->
                <div class="div_routes count_me">


                  <?php 
                  // echo '<pre>';
                  // print_r($tour_route);die;
                  if($key_point > 0){  //  $key_point < sizeof($point_model)-1    ?>
                  
                 <?php  foreach ($tour_route as $key11 => $value11){ 

                  if($key_point == $key11 + 1){  // $key_point == $key11
                  ?>

                   <div  class=" ">
                          <div class="row martop10 marbottom10">
                            <div class="row margin0">
                              <div class="col-lg-1 ">
                                <img src="<?=$bUrl ?>Arrow_Down.png" height="35" padding="10% 2% 1%"> 
                              </div>
                              <label for="TblAdmin_adm_uname" class="martop10 col-sm-2 control-label required">Route Audio Files <span class="required">*</span></label>
                              <div class="col-lg-3 martop10">
                                <?php if(sizeof($value11) > 0){ ?>
                                <?= $form->field($tourroute, 'media_name[]')->fileInput(['autofocus'=>'true','maxlength' => true ,'class' => 'route_audio validate[checkFileType[MP3|mp3]]'])->label(false) ?>
                                <?php }else{ ?>
                                <?= $form->field($tourroute, 'media_name[]')->fileInput(['autofocus'=>'true','id' => "route_$key11",'maxlength' => true ,'class' => 'route_audio validate[required,checkFileType[MP3|mp3]]'])->label(false) ?>
                                <?php }?>
                              </div>
                              <?php if(sizeof($value11) > 0){ ?>
                              <div class="col-lg-6 music_thumb">
                                <?= $form->field($tourroute, "media_id[]")->hiddenInput(['value'=> $value11['media_id'] ])->label(false) ?>
                                Uploaded file: <span><span><?=$value11['name'] ?></span><img data-type="audio" title="<?=$value11['name'] ?>" src="<?=$baseUrl ?>/images/music.png" class="play-media-modal" height="50" width="50" data-val="<?=Yii::$app->params['uploadUrl'] ?>route/<?= $value11['media_name'] ?>"> </span>
                              </div>
                              <?php } ?>
                            </div>
                          </div>                  
                    </div>   
                  <?php } } ?>
                  <?php }  ?>

                     <div  class=" ">
                        <div class="col-lg-12 border-dotted div_routes">
                            <div style="float: right;margin: 15px 0;">
                              <a href="javascript:void(0)" class="btn btn-danger remove_this_point"  style="display:none" data-delete = "<?=$value_point['point_id'] ?>">
                                Remove Point
                              </a>
                            </div>
                             <div class="form-group martop10">
                              
                                <div class="row">
                                    <div class="row">
                                    <div class="col-lg-12">
                                        <label for="TblAdmin_adm_uname" class="col-sm-2 control-label required">Point Name</label>
                                  
                                        <div class="col-sm-5">
                                            <?= $form->field($pointModel, "point_id[][]")->hiddenInput(['value'=> $value_point['point_id']])->label(false) ?>
                                            <?= $form->field($pointModel, 'point_name[]')->textInput(['autofocus'=>'true',"value"=>$value_point['point_name'],'maxlength' => true,"id"=>"auto_".$key_point,"data-id"=>$key_point,"class"=>"form-control autocomplete validate[required]"]) ?>
                                            <?= $form->field($pointModel, 'place_id[]')->dropDownList($pointModel->iconlist,['prompt'=>'-Choose category-', 'options'=>[$value_point['place_id']=>["Selected"=>true] ] ]) ?>
                                            <?= $form->field($pointModel, 'point_latitude[]')->textInput([ "class"=>"form-control point_latitudes","value"=>$value_point['point_latitude'],"id"=> $key_point. "_point_latitudes" ]) ?>
                                            <?= $form->field($pointModel, 'point_longitude[]')->textInput([ "class"=>"form-control point_longitudes","value"=>$value_point['point_longitude'],"id"=> $key_point. "_point_longitudes" ]) ?>
                                            <?= $form->field($pointModel, 'point_description[]')->textArea([ "class"=>"form-control validate[required]","value"=>$value_point['point_description'] ]) ?>
                                            <?= $form->field($pointModel, 'overview_polyline[]')->hiddenInput(["value"=>$value_point['overview_polyline']])->label(false) ?>
                                            <?= $form->field($pointModel, 'overview_path[]')->hiddenInput(["value"=>$value_point['overview_path']])->label(false) ?>
                                            <input type="hidden" value="<?=$value_point['overview_path'] ?>" class="overview_class" id="<?=$key_point?>">
                                        </div>  
                                    </div>  
                                    </div>  
                     
                                    <div class="row martop10">

                                            <div class="col-sm-10 col-sm-offset-2 marbottom10 required">
                                              <div class="panel-title">
                                                Add Media (Audio/Video/Images)     
                                              </div> 
                                            </div>
                                            <div class="copy_this_media" style="display:none">
                                                <div class="martop10 new_media_div" >
                                                  <div class="row margin0">
                                                    <div class="col-sm-offset-1 col-sm-1">
                                                      <?php //echo $form->field($pointmediaModel, "media_type[$key_point][]")->dropDownList(['image'=>'Image','audio'=>'Audio','video' => 'Video'])->label(false) ?>  
                                                    </div>
                                                    <div class="col-sm-3">
                                                      <?= $form->field($pointmediaModel, "media_name[$key_point][]")->fileInput(['data-id'=>$key_point,'autofocus'=>'true','maxlength' => true,'class' => 'point_media validate[required,checkFileType[jpg|jpeg|gif|JPG|png|PNG|MP3|mp3|MP4|mp4]]'])->label(false) ?>
                                                    </div>  
                                                    <div class="col-sm-1 padding0">
                                                      <!-- Display After  -->
                                                    </div>
                                                    <div class="col-sm-2 padding0">
                                                      <?php // echo $form->field($pointmediaModel, "after_time[$key_point][]")->textInput([ "placeholder" => "hh:mm",'readonly'=>'readonly','class' => 'form-control time_element validate[required]]'])->label(false) ?>
                                                    </div>
                                                    
                                                    <div class="col-sm-1 ">
                                                      <a href="javascript:void(0)" class="btn btn-info"  title="Pick to drag and drop">
                                                        <i class="fa fa-arrows-v m-right-xs"></i>
                                                      </a>
                                                    </div>

                                                    <div class="col-sm-1 ">
                                                      <a href="javascript:void(0)" class="btn btn-danger remove_this_media">
                                                        <i class="fa fa-minus m-right-xs"></i>
                                                      </a>
                                                    </div>
                                                  </div>  
                                                </div> 
                                            </div>
                                    
                                            <div class="">
                                              <div class="append_media_here ">
                                            <?php 
                                            $a = -1;
                                               foreach ($point_media_model as $key_media => $value_media){ 
                                                
                                                if($value_media['point_id'] == $value_point['point_id'])
                                                {
                                                $a = $a+1;
                                                ?>
                                                  
                                                <div class="martop10 new_media_div" >
                                                  <div class="row margin0 thisone">
                                                    <div class="col-sm-offset-1 col-sm-1">
                                                      <?php // echo $form->field($pointmediaModel, "media_type[$key_point][]")->dropDownList(['image'=>'Image','audio'=>'Audio','video' => 'Video','value'=> $value_media['media_type'], 'multiple' => 'multiple'])->label(false) ?>  
                                                    </div>
                                                      
                                                    <div class="col-sm-4">
                                                      <div class="col-sm-10 padding0">
                                                        <?= $form->field($pointmediaModel, "media_id[$key_point][]")->hiddenInput(['value'=> $value_media['media_id'],'data-id'=>$key_point, 'class' => 'point_id_val'])->label(false) ?>
                                                        <?= $form->field($pointmediaModel, "media_name[$key_point][]")->fileInput(['data-id'=>$key_point, 'class' => 'point_media validate[checkFileType[jpg|jpeg|gif|JPG|png|PNG|MP3|mp3|MP4|mp4]]'])->label(false) ?>
                                                      </div>  
                                                      <div class="col-sm-2">
                                                        <?php if($value_media['media_type'] == 'image'){ ?>
                                                        <img title="<?=$value_media['name'] ?>" src="<?=Yii::$app->params['uploadUrl'] ?>point/media/thumb/thumb_<?= $value_media['media_name'] ?>" height="50" width="50"  data-val="<?=Yii::$app->params['uploadUrl'] ?>point/<?= $value_media['media_name'] ?>" class="play-media-modal"> 
                                                        <?php }else if($value_media['media_type'] == 'audio'){ ?>
                                                        <img title="<?=$value_media['name'] ?>" data-type="<?=$value_media['media_type'] ?>" src="<?=$baseUrl ?>/images/music.png" class="play-media-modal" height="50" width="50" data-val="<?=Yii::$app->params['uploadUrl'] ?>point/<?= $value_media['media_name'] ?>">
                                                        <?php }else{ ?>
                                                        <!-- <img src="<?=$baseUrl ?>/images/video.png" height="40" width="40" title="Click to play Video" data-type="<?=$value_media['media_type'] ?>"  class="img_delete_video_at_media play-media-modal" data-val="<?=Yii::$app->params['JW_videopath']."".$value_media['video_key'].".mp4" ?>">  -->
                                                        <img title="<?=$value_media['name'] ?>" 
                                                        data-type="<?=$value_media['media_type'] ?>" 
                                                        src="<?=$baseUrl ?>/images/video.png" class="play-media-modal" height="50" width="50" data-val="<?=Yii::$app->params['JW_videopath']."".$value_media['video_key'].".mp4" ?>">
                                                        <?php } ?>
                                                      </div>  
                                                    </div>  
                                                    
                                                    <div class="col-sm-2">
                                                      <?=$value_media['name'] ?>
                                                      <?php // echo $form->field($pointmediaModel, "after_time[$key_point][]")->textInput([ "class"=>"form-control time_element validate[required]",'readonly'=>'readonly',"placeholder" => "hh:mm",'value'=> $value_media['after_time']])->label(false) ?>
                                                    </div>
                                                    <div class="col-sm-1 ">
                                                        <a href="javascript:void(0)" class="btn btn-info"  title="Pick to drag and drop">
                                                          <i class="fa fa-arrows-v m-right-xs"></i>
                                                        </a>
                                                      </div>
                                                      
                                                    <div class="col-sm-1 ">
                                                      <a href="javascript:void(0)" class="btn btn-danger delete_this_media" data-id="<?=$value_media['media_id'] ?>">
                                                        <i class="fa fa-minus m-right-xs"></i>
                                                      </a>
                                                    </div>
                                                  </div>  
                                                    
                                                </div>   
                                                  
                                            <?php } } ?>

                                              </div>
                                              </div>

                                          <div class="col-sm-offset-2 martop10 col-sm-1">
                                            <a href="javascript:void(0)" class="btn btn-success add_new_media">
                                              Add
                                            </a>
                                          </div>  
                                    </div>
                                </div>  
                                  
                             </div>
                        </div>
                    
               
                     </div> 
             </div>
       

      <?php } ?>
    </div>
            <!-- Pointof interest end-->
             

    </div>  
    </div>  
    </div>  
    </div>  
    </div>  
    </div>  
    </div>  
    </div>  
   
      
    <div class="row margin0 martop10">
      <div class="form-group">
          <div class=" martop10 col-sm-1  ">
            <a href="javascript:void(0)" id="add_new_route" class="btn btn-success">
              Add new point
            </a>
          </div>  
        </div>  
    </div>
       

        <div class="col-lg-12 padding0" style="height:0" id="map_view">
      <div class="col-lg-12 padding0 martop10">
         <div class="col-lg-8 padding0">
          <div id="map"></div>
         </div>
         <div class="col-lg-4" id="panel_right"  style="display:none">
          <div class="col-lg-12">
            <p>Total Distance: <span id="total"></span></p>
          </div>
          <div class="col-lg-12" id="right-panel" >
            
          </div>
         </div>
      </div>  
     </div>  


    <div class="col-lg-12">
      <div class="col-lg-12 martop10">
        <div class="form-group martop10">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
            <?= Html::Button('Reset', ['class' => 'btn btn-default','id'=>'reset_all']) ?>
        </div>
      </div>  
      <?php ActiveForm::end(); ?>
    </div>  

  </div>  
    

  <!-- -->
   <div id="copy_this" style="display:none">

     <div class="count_me">
            <!-- Seprator start-->
              <div class="row martop10 marbottom10">
                <div class="row margin0">
                  <div class="col-lg-1 ">
                     <img src="<?=$bUrl ?>Arrow_Down.png" height="35" padding="10% 2% 1%"> 
                  </div>
                  <label for="TblAdmin_adm_uname" class="martop10 col-sm-2 control-label required">Route Audio Files <span class="required">*</span></label>
                  <div class="col-lg-4 martop10">
                    <?= $form->field($tourroute, 'media_name[]')->fileInput(['autofocus'=>'true','maxlength' => true,"class"=>"route_audio change_name_here_route validate[required,checkFileType[MP3|mp3]]"])->label(false) ?>
                  </div>
                </div>
              </div>
            <!-- Pointof interest start -->
            <div class="col-lg-12 border-dotted div_routes">
                <div style="float: right;margin: 15px 0;">
                        <a href="javascript:void(0)" class="btn btn-danger remove_this_point"  style="display:none" data-delete = "0">
                          Remove Point
                        </a>
                      </div>
             <div class="form-group martop10">
                <div class="row">
                  <label for="TblAdmin_adm_uname" class="col-sm-2 control-label required">Point Name</label>
                  <div class="col-sm-5">
                      <?php // $form->field($pointModel, 'point_name[]')->textInput(['autofocus'=>'true','maxlength' => true,"id"=>"autocomplete"]) ?>
                      <?= $form->field($pointModel, 'point_name[]')->textInput(['autofocus'=>'true','maxlength' => true,"id"=>"auto_1","class"=>"change_id_here form-control autocomplete validate[required]","data-id"=> "1"]) ?>
                      <?= $form->field($pointModel, 'place_id[]')->dropDownList($pointModel->iconlist,['prompt'=>'-Choose category-']) ?>
                      <?= $form->field($pointModel, 'point_latitude[]')->textInput([ "class"=>"form-control point_latitudes validate[required]" ]) ?>
                      <?= $form->field($pointModel, 'point_longitude[]')->textInput([ "class"=>"form-control point_longitudes validate[required]" ]) ?>
                      <?= $form->field($pointModel, 'point_description[]')->textArea([ "class"=>"validate[required] form-control"]) ?>
                      <?= $form->field($pointModel, 'overview_polyline[]')->hiddenInput([])->label(false) ?>
                      <?= $form->field($pointModel, 'overview_path[]')->hiddenInput([])->label(false) ?>
                  </div>  

                <div class="row martop10">

                  <div class="col-sm-10 col-sm-offset-2 marbottom10 required">
                    <div class="panel-title">
                      Add Media (Audio/Video/Images)     
                    </div> 
                  </div>
                    <div class="copy_this_media" style="display:none">
                        <div class="martop10 new_media_div" >
                        <div class="row margin0">
                          <div class="col-sm-offset-1 col-sm-1">
                            <?php // echo $form->field($pointmediaModel, 'media_type[1][]')->dropDownList(['image'=>'Image','audio'=>'Audio','video' => 'Video'],["class"=>"change_name_here_type form-control"])->label(false) ?>  
                          </div> 
                          <div class="col-sm-3">
                            <?= $form->field($pointmediaModel, 'media_name[1][]')->fileInput(['data-id'=> '1', 'autofocus'=>'true','maxlength' => true,"class"=>"point_media change_name_here_name validate[required,checkFileType[jpg|jpeg|gif|JPG|png|PNG|MP3|mp3|MP4|mp4]]"])->label(false) ?>
                          </div>  
                          <div class="col-sm-1 padding0">
                            <!-- Display After -->
                          </div>
                          <div class="col-sm-2 padding0">

                            
                          </div>
                          <div class="col-sm-1 ">
                            <a href="javascript:void(0)" class="btn btn-info"  title="Pick to drag and drop">
                              <i class="fa fa-arrows-v m-right-xs"></i>
                            </a>
                          </div>
                          <div class="col-sm-1 ">
                            <a href="javascript:void(0)" class="btn btn-danger remove_this_media">
                              <i class="fa fa-minus m-right-xs"></i>
                            </a>
                          </div>
                        </div>  
                      </div> 
                    </div>
                    
                  <div class="">
                    <div class="append_media_here ">

                      <div class="martop10 new_media_div" >
                        <div class="row margin0">
                          <div class="col-sm-offset-1 col-sm-1">
                            <?php // echo $form->field($pointmediaModel, 'media_type[1][]')->dropDownList(['image'=>'Image','audio'=>'Audio','video' => 'Video'],["class"=>"change_name_here_type form-control"])->label(false) ?>  
                          </div>
                          <div class="col-sm-3">
                            <?= $form->field($pointmediaModel, 'media_name[1][]')->fileInput(['data-id'=> '1','autofocus'=>'true','maxlength' => true,"class"=>"point_media change_name_here_name validate[required,checkFileType[jpg|jpeg|gif|JPG|png|PNG|MP3|mp3|MP4|mp4]]"])->label(false) ?>
                          </div>  
                          <div class="col-sm-1 padding0">
                            <!-- Display After -->
                          </div>
                          <div class="col-sm-2 padding0">
                            <?php //echo $form->field($pointmediaModel, 'after_time[1][]')->textInput([ "class"=>"form-control time_element change_name_here_aftertime validate[required]",'readonly'=>'readonly',"placeholder" => "hh:mm" ])->label(false) ?>
                          </div>
                          <div class="col-sm-1 ">
                          <a href="javascript:void(0)" class="btn btn-info"  title="Pick to drag and drop">
                            <i class="fa fa-arrows-v m-right-xs"></i>
                          </a>
                        </div>
                          <div class="col-sm-1 ">
                            <a href="javascript:void(0)" class="btn btn-danger remove_this_media">
                              <i class="fa fa-minus m-right-xs"></i>
                            </a>
                          </div>
                        </div>  
                      </div>                           
 
                    </div>
                  
                    <div class="col-sm-offset-2 martop10 col-sm-1">
                      <a href="javascript:void(0)" class="btn btn-success add_new_media">
                        Add
                      </a>
                    </div>  
                  </div>
                </div>  
            </div>
          </div>
          </div>
        </div> 
   </div>
        

    

<!-- Modal -->
<div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body" id="body_append" style="text-align: center;"></div>
     <!--  <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
    </div>
  </div>
</div>
        

<!-- Modal -->
<div class="modal fade bs-example-modal-sm" id="myModal_media" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body" id="body_append" style="text-align: center;"><div id="myDiv1">Player loading...</div></div>
      <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
    </div>
  </div>
</div>
        
        
<?php
$url_ = $bUrl.'tour/updateajax';
$pointurl_ = $bUrl.'tour/deleteajaxpoint';


$this->registerJs(' 

  function show_sel1(c)
  {
    if(c==true)
      jQuery("#auth_reg").removeClass("hide");
  }
  function hide_sel1(c)
  {
    if(c==true)
    {
      jQuery("#auth_reg").addClass("hide");
    }
  } 

  $(document).on("keypress",".point_latitudes",function(e){
      var regex = new RegExp("^[0-9-.]+$");
      var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
      if (regex.test(str)) {
          return true;
      }

      e.preventDefault();
      return false;
  });

  $(document).on("keypress",".point_longitudes",function(e){
      var regex = new RegExp("^[0-9-.]+$");
      var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
      if (regex.test(str)) {
          return true;
      }

      e.preventDefault();
      return false;
  });

 jQuery(document).ready(function(){
 


    $(\'[data-toggle="popover"]\').popover();


      $(\'#myModal\').on(\'hide.bs.modal\', function (e) {
        $(\'#body_append\').html(\'\');
      });

      $(\'#myModal_media\').on(\'hide.bs.modal\', function (e) {
        jwplayer("myDiv1").stop();
        
      });
  
    var validator = jQuery("#w0").validationEngine({promptPosition: \'inline\',maxErrorsPerField:1,scrollOffset:500});

    

    jQuery(document).on(\'click\',\'#add_new_route\',function(){
      var count = $(\'.count_me\').length - 1;      

      $(\'#copy_this .change_name_here_name\').each(function(index,value){
        $(this).attr(\'name\',\'TourPointMedia[media_name][\'+count+\'][]\');
          $(this).attr(\'id\',\'change_name_here_name_\'+count);
          $(this).attr(\'data-id\',count);
      });

      $(\'#copy_this .change_name_here_type\').each(function(index,value){
        $(this).attr(\'name\',\'TourPointMedia[media_type][\'+count+\'][]\');
          $(this).attr(\'id\',\'change_name_here_type_\'+count);
      });

      $(\'#copy_this .change_name_here_aftertime\').each(function(index,value){
        $(this).attr(\'name\',\'TourPointMedia[after_time][\'+count+\'][]\');
          $(this).attr(\'id\',\'change_name_here_aftertime_\'+count);
      });

      $(\'#copy_this .change_name_here_route\').each(function(index,value){
        $(this).attr(\'name\',\'TourRouteMedia[media_name][]\');
          $(this).attr(\'id\',\'change_name_here_route_\'+count);
      });



      $(\'.change_id_here\').attr(\'id\',\'auto_\'+count);
      $(\'.change_id_here\').attr(\'data-id\',count);
      
      var htm = jQuery("#copy_this").html();
      jQuery("#append_here").append(htm);

      $(\'#auto_\'+count).removeClass(\'change_id_here\');
      // jQuery(".time_element").timepicki({show_meridian:false});
      

       $(\'.time_element\').each(function(index,value){
          $(this).attr(\'id\',\'time_element\'+index);
       });
 
 
       $(\'.route_audio\').each(function(index,value){
          $(this).attr(\'id\',\'route_audio\'+index);
       });
  initAutocomplete();

      // validator.resetForm();
      jQuery("#w0").validationEngine("hide");


  $(\'.point_latitudes\').each(function(index,value){
$(this).attr(\'id\',index+\'_point_latitudes\');
                  
              });

  $(\'.point_longitudes\').each(function(index,value){
$(this).attr(\'id\',index+\'_point_longitudes\');
                  
              });


    var len = $(\'.remove_this_point\').length;
    
    if(len > 3){

      $(\'.remove_this_point\').each(function(index,value){
          if(index == 0){
            $(this).hide();
          }else{
            $(this).show();
          }
      });
    }else{
      $(\'.remove_this_point\').each(function(index,value){
            $(this).hide();
      });
    }


    });

    

    jQuery(document).on(\'click\',\'.remove_this_point\',function(){
     
     var this_ = $(this);
     var data_id_point = $(this).attr(\'data-delete\');
     var data_deleted_id = $(this).parent().parent().find(\'.point_media\').attr(\'data-id\');
     
     if(data_id_point > 0){

          var r = confirm("Are you sure want to delete point permanantly?");
          if (r == true) {
               $.ajax({
                  url: \''.$pointurl_.'\',
                  type: "post",
                  data: {\'point_id\': data_id_point},
                  success:function(data){
                    /**/
                    
                    $(\'.point_media\').each(function(index,value){
                      var dataid = $(this).attr(\'data-id\');
                      
                      if(dataid > data_deleted_id){
                        var newdataid = dataid - 1;
                        

                        $(this).attr(\'name\',\'TourPointMedia[media_name][\'+newdataid+\'][]\');
                        $(this).attr(\'data-id\',  newdataid);
                      }
                    });
               
                    $(\'.point_id_val\').each(function(index,value){
                      var dataid = $(this).attr(\'data-id\');
                      
                      if(dataid > data_deleted_id){
                        var newdataid = dataid - 1;
                        

                        $(this).attr(\'name\',\'TourPointMedia[media_id][\'+newdataid+\'][]\');
                        $(this).attr(\'data-id\',  newdataid);
                      }
                    });
              


      $(\'.autocomplete\').each(function(index,value){

          var dataid = $(this).attr(\'data-id\');

          if(dataid > data_deleted_id){
            var newdataid = dataid - 1;

            $(this).attr(\'id\',  "auto_"+newdataid);
            $(this).attr(\'data-id\',  newdataid);
          }


        });

 
  initAutocomplete();

              this_.parent().parent().parent().parent().next().find(\'.route_audio\').attr(\'class\',\'route_audio validate[required,checkFileType[MP3|mp3]]\');
              this_.parent().parent().parent().parent().next().find(\'.music_thumb\').slideUp();
              jQuery("#w0").validationEngine("hide");
 
                    this_.parent().parent().parent().closest(\'.count_me\').fadeOut(500, function() {
                      $(this).remove();

                       var len = $(\'.remove_this_point\').length;
                        
                        if(len > 3){
                          
                          $(\'.remove_this_point\').each(function(index,value){
                              if(index == 0){
                                $(this).hide();
                              }else{
                                $(this).show();
                              }
                          });
                          // refresh_all();
                        }else{
                          
                          $(\'.remove_this_point\').each(function(index,value){
                                $(this).hide();
                          });
                          // refresh_all();
                        }
                  });

  

  
  var explode = function(){
        drawmapinit();
  };
  setTimeout(explode,1000);
                    /**/
                  },
              });
          }

     }else{
      /**/
                    $(\'.point_media\').each(function(index,value){
                      var dataid = $(this).attr(\'data-id\');
                      
                      if(dataid > data_deleted_id){
                        var newdataid = dataid - 1;
                        

                        $(this).attr(\'name\',\'TourPointMedia[media_name][\'+newdataid+\'][]\');
                        $(this).attr(\'data-id\',  newdataid);
                      }
                    });
             

                  this_.parent().parent().parent().closest(\'.count_me\').fadeOut(500, function() {
                      $(this).remove();

                       var len = $(\'.remove_this_point\').length;
                        
                        if(len > 3){
                          
                          $(\'.remove_this_point\').each(function(index,value){
                              if(index == 0){
                                $(this).hide();
                              }else{
                                $(this).show();
                              }
                          });
                          // refresh_all();
                        }else{
                          
                          $(\'.remove_this_point\').each(function(index,value){
                                $(this).hide();
                          });
                          // refresh_all();
                        }
                  });
                    /**/

     }


  var explode = function(){
        drawmapinit();
  };
  setTimeout(explode,1000);
        

    });



    jQuery(document).on(\'click\',\'.add_new_tour_media\',function(){
       
      var new_media_div = jQuery(\'#tour_here\').children().clone();
      jQuery(this).parent().parent().parent().find(\'.append_media_here\').append(new_media_div);
      jQuery(".new_media_div").show();
      // jQuery(".time_element").timepicki({show_meridian:false, start_time: ["00","00"]});

       $(\'.tour_media_media_name\').each(function(index,value){
          $(this).attr(\'id\',\'tour_media_media_name_\'+index);
       });

       $(\'.point_media\').each(function(index,value){
          $(this).attr(\'id\',\'point_media_\'+index);
       });


       $(\'.time_element\').each(function(index,value){
          $(this).attr(\'id\',\'time_element\'+index);
       });
 
       $(\'.route_audio\').each(function(index,value){
          $(this).attr(\'id\',\'route_audio\'+index);
       });
 

      // validator.resetForm();
jQuery("#w0").validationEngine("hide");

    });

jQuery(document).on(\'click\',\'.play-media-modal\',function(){
      $(\'#body_append\').html(\'\');
      

      var type_value = $(this).attr(\'data-type\');  
      var val_value = $(this).attr(\'data-val\');
      var title_value = $(this).attr(\'title\');
        $(\'.modal-title\').html(\'<b>\'+title_value+\'</b>\');

      if(type_value == \'audio\'){
        
        $(\'#myModal_media\').modal(\'show\');

        var explode1 = function(){
              jwplayer().remove();
        };
        var explode2 = function(){
              jwplayer("myDiv1").setup({
                  "file": val_value
              }).play();
        };
        setTimeout(explode1,1000);
        setTimeout(explode2,1500);
      }
      else if(type_value == \'video\'){
        $(\'#myModal_media\').modal(\'show\');

        var explode1 = function(){
              jwplayer().remove();
        };
        var explode2 = function(){
              jwplayer("myDiv1").setup({
                  "file": val_value
              }).play();
        };
        setTimeout(explode1,1000);
        setTimeout(explode2,1500);
      }else{
        var htm = \'<img src="\'+val_value+\'" style="width:100%">\';
        $(\'#body_append\').html(htm);
        $(\'#myModal\').modal(\'show\');
      }
    });
    jQuery(document).on(\'click\',\'.add_new_media\',function(){
//      var new_media_div = jQuery(\'#abc_here\').children().clone();
      var new_media_div =  $(this).parent().parent().parent().find(\'.copy_this_media\').html();
      jQuery(this).parent().parent().parent().find(\'.append_media_here\').append(new_media_div);
      
      jQuery(".new_media_div").show();
      // jQuery(".time_element").timepicki({show_meridian:false, start_time: ["00","00"]});


       $(\'.point_media\').each(function(index,value){
          $(this).attr(\'id\',\'point_media_\'+index);
       });

       $(\'.route_audio\').each(function(index,value){
          $(this).attr(\'id\',\'route_audio\'+index);
       });
 

       $(\'.tour_media_media_name\').each(function(index,value){
          $(this).attr(\'id\',\'tour_media_media_name_\'+index);
       });

       $(\'.time_element\').each(function(index,value){
          $(this).attr(\'id\',\'time_element\'+index);
       });
 

      // validator.resetForm();
jQuery("#w0").validationEngine("hide");
    });

    jQuery(document).on(\'click\',\'.remove_this_media\',function(){
      jQuery(this).parent().parent().parent().remove();
      // validator.resetForm();
      jQuery("#w0").validationEngine("hide");
    });
    
    jQuery(document).on(\'change\',\'.point_latitudes\',function(){
      drawmap();
    });

    jQuery(document).on(\'change\',\'.point_longitudes\',function(){
      drawmap();
    });

    var len = $(\'.remove_this_point\').length;
            
            if(len > 3){
              
              $(\'.remove_this_point\').each(function(index,value){
                  if(index == 0){
                    $(this).hide();
                  }else{
                    $(this).show();
                  }
              });
              // refresh_all();
            }else{
              
              $(\'.remove_this_point\').each(function(index,value){
                    $(this).hide();
              });
              // refresh_all();
            }
 var tour_total_time = '.json_encode($tour_total_time).';
             

      // jQuery("#tour_total_time").timepicki({show_meridian:false, start_time: tour_total_time});


    var explode = function(){
          drawmapinit();
    };
    setTimeout(explode,1000);
          
 // $(\'#w0\').on(\'beforeValidate\', function (event, messages) {
 //          $( "#loader" ).show();
 //           setTimeout(function(){
 //            $( "#loader" ).hide();
 //          },3000);
 //          console.log("show");
 //    });
    $(\'#w0\').on(\'afterValidate\', function (event, messages) {
       if(typeof $(\'.has-error\').first().offset() !== \'undefined\') {
          $(\'html, body\').animate({
              scrollTop: $(\'.has-error\').first().offset().top - 250
          }, 1000);

          setTimeout(function(){
            $( "#loader" ).hide();
          },3000);
       setTimeout(function(){
            $( "#loader" ).hide();
          },3000);
          
      }else{
        if($("#w0").validationEngine(\'validate\')){
          $( "#loader" ).show();    
        }
      }
    });

$(".append_media_here").sortable({
          connectWith: ".append_media_here",
          containment: "parent"
    });

});', \yii\web\View::POS_READY);
?>  
<script>

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete()
      {
        // location types.
//        autocomplete1 = new google.maps.places.Autocomplete((document.getElementsByName("point_name").item(0).value),
//        {types: ['geocode']});

       var acInputs = document.getElementsByClassName("autocomplete");
       
        
        for (var i = 0; i < acInputs.length; i++)
       {
           
     // var autocomplete = new google.maps.places.Autocomplete(acInputs[i],{types: ['geocode'],componentRestrictions: {country: 'in'}});

     var autocomplete = new google.maps.places.Autocomplete(acInputs[i],{componentRestrictions: {country: 'in'}});
     
      autocomplete.inputId = acInputs[i].id;
            var data_id = acInputs[i].id;
            
            
            
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                  var place = this.getPlace();
                  
                  
                  $('#'+this.inputId).parent().parent().find('.point_latitudes').val(place.geometry.location.lat());
                  $('#'+this.inputId).parent().parent().find('.point_longitudes').val(place.geometry.location.lng());


                    var explode = function(){
                          drawmap();
                    };
                    setTimeout(explode,1000);
                          
            });
        }


//            google.maps.event.addListener(autocomplete1, 'place_changed', function () 
//            {
//                  var place = autocomplete1.getPlace();
//                  document.getElementById('point_latitude').value = place.geometry.location.lat();
//                  document.getElementById('point_longitude').value = place.geometry.location.lng();
//              });
             
        }


  function drawmapinit(){
            var markers=[];

            /**/
            var lat_arr = [];
            var long_arr = [];
            var overview_polyline = [];
            var overview_path = [];
            $( "input[name='TourPoint[point_latitude][]']" ).each(function(){
                 var input = $(this).val(); // This is the jquery object of the input, do what you will
                 if(input != ''){
                  lat_arr.push(input);
                }                
            });
            $( "input[name='TourPoint[point_longitude][]']" ).each(function(){
                 var input = $(this).val(); // This is the jquery object of the input, do what you will
                 if(input != ''){
                  long_arr.push(input);
                }   
            });
            
            $( "input[name='TourPoint[overview_polyline][]']" ).each(function(index){
                    $(this).attr('data-id',index);

                    var input = $(this).val(); // This is the jquery object of the input, do what you will
                     if(input != ''){
                      overview_polyline.push(input);
                    } 

            });
            $( "input[name='TourPoint[overview_path][]']" ).each(function(index){
                    $(this).attr('data-id',index);
            });

            $( "input[class='overview_class']" ).each(function(index){
                      var input = $(this).val(); // This is the jquery object of the input, do what you will
                       if(input != ''){
                        overview_path.push(input);
                      } 

              });
            

            $("#map").empty();
            $("#right-panel").empty();
            var wps=[];
            var directionsService = [];
            var directionsDisplay = [];
            var start; 
            var end; 

            if(lat_arr.length > 1 && long_arr.length > 1){

             var map = new google.maps.Map(document.getElementById('map'), {
                  zoom: 4,
                  center: new google.maps.LatLng(lat_arr[0],long_arr[0]),
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                });
              

              for(var i = 0; i < markers.length; i++) {
                      markers[i].setMap(null);
              }
               var markers=[];
             lat_arr.forEach(function (item, index, array) {

                   markers[index] = new google.maps.Marker({
                        position: new google.maps.LatLng(lat_arr[index],long_arr[index]),
                        draggable: false,
                        map: map
                      });
              });

             

              lat_arr.forEach(function (item, index, array) {
                if(index < lat_arr.length-1) {

                   setTimeout( function () {

                  start  =  new google.maps.LatLng(lat_arr[index],long_arr[index]);
                  end = new google.maps.LatLng(lat_arr[index+1],long_arr[index+1]);
                  
                  directionsService[index] = new google.maps.DirectionsService;
                  directionsDisplay[index] = new google.maps.DirectionsRenderer({
                    draggable: true,
                    map: map,
                    panel: document.getElementById('right-panel')
                  });

    // var decodedPath = google.maps.geometry.encoding.decodePath("}~kvHmzrr@ba\\hnc@jiu@r{Zqx~@hjp@pwEhnc@zhu@zflAbxn@fhjBvqHroaAgcnAp}gAeahAtqGkngAinc@_h|@r{Zad\\y|_D}_y@swg@ysg@}llBpoZqa{@xrw@~eBaaX}{uAero@uqGadY}nr@`dYs_NquNgbjAf{l@|yh@bfc@}nr@z}q@i|i@zgz@r{ZhjFr}gApob@ff}@laIsen@dgYhdPvbIren@"); 
    // var decodedLevels = decodeLevels("BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB");

                // console.log(path);
                

                // console.log('overview_path');
                var res = overview_path[index].split("-|-");

                var over_lat_array = res[0].split(",");
                var over_lng_array = res[1].split(",");
                var wps = [];
                var over_lat_array_len = over_lat_array.length;
                
                
                if(over_lat_array_len > 20)
                  var total_parts = parseInt(over_lat_array_len / 20);
                else
                  var total_parts = 1;
                
                var total_parts = 1;
                
                var lk = 0;
                 for (var j = 0; j < over_lat_array.length; j=j+total_parts) {
                  if(over_lat_array[j-1] != over_lat_array[j] && over_lng_array[j-1] != over_lng_array[j] && lk < 22){

                    wps.push({
                        location: new google.maps.LatLng(over_lat_array[j],over_lng_array[j]),
                        stopover: true
                      });
                    lk++;
                  }

                  }
              

                

                var request = {
                        origin: start,
                        destination: end,
                        waypoints:wps,
                        // path: decodedPath,
                        // levels: decodedLevels,
                        travelMode: google.maps.TravelMode.DRIVING
                };
                directionsDisplay[index].addListener('directions_changed', function() {
                  computeTotalDistance(directionsDisplay[index].getDirections(),index);
                  $(".adp-directions").parent().attr('style','height:150px;overflow:auto');
                });

                displayRoute(request, directionsService[index],directionsDisplay[index]);
                  }, index * 1500);
                 
                    $(".adp-directions").parent().attr('style','height:150px;overflow:auto');
                    $("#map_view").css("height","400px");
                    $("#panel_right").show();

                  }
                });

                    return false;
            }else{
              $("#map_view").css("height","0");
              $("#panel_right").hide();
              $("#map").empty();
              $("#right-panel").empty();

            }
            /**/
        }

function decodeLevels(encodedLevelsString) {
    var decodedLevels = [];

    for (var i = 0; i < encodedLevelsString.length; ++i) {
        var level = encodedLevelsString.charCodeAt(i) - 63;
        decodedLevels.push(level);
    }
    return decodedLevels;
}

  function drawmap(){

            /**/
            var lat_arr = [];
            var long_arr = [];
            var overview_polyline = [];
            var overview_path = [];
            $( "input[name='TourPoint[point_latitude][]']" ).each(function(){
                 var input = $(this).val(); // This is the jquery object of the input, do what you will
                 if(input != ''){
                  lat_arr.push(input);
                }                
            });
            $( "input[name='TourPoint[point_longitude][]']" ).each(function(){
                 var input = $(this).val(); // This is the jquery object of the input, do what you will
                 if(input != ''){
                  long_arr.push(input);
                }   
            });
            
            $( "input[name='TourPoint[overview_polyline][]']" ).each(function(index){
                    $(this).attr('data-id',index);

                    var input = $(this).val(); // This is the jquery object of the input, do what you will
                     if(input != ''){
                      overview_polyline.push(input);
                    } 

            });
            $( "input[name='TourPoint[overview_path][]']" ).each(function(index){
                    $(this).attr('data-id',index);

                    var input = $(this).val(); // This is the jquery object of the input, do what you will
                     if(input != ''){
                      overview_path.push(input);
                    } 

            });


            $("#map").empty();
            $("#right-panel").empty();
            var wps=[];
            var markers=[];
            var directionsService = [];
            var directionsDisplay = [];
            var start; 
            var end; 

            if(lat_arr.length > 1 && long_arr.length > 1){




             var map = new google.maps.Map(document.getElementById('map'), {
                  zoom: 4,
                  center: new google.maps.LatLng(lat_arr[0],long_arr[0])
                });

             lat_arr.forEach(function (item, index, array) {
                   markers[index] = new google.maps.Marker({
                        position: new google.maps.LatLng(lat_arr[index],long_arr[index]),
                        draggable: true,
                        map: map
                      });
              });

              lat_arr.forEach(function (item, index, array) {
                if(index < lat_arr.length-1) {

                  setTimeout( function () {


                  start  =  new google.maps.LatLng(lat_arr[index],long_arr[index]);
                  end = new google.maps.LatLng(lat_arr[index+1],long_arr[index+1]);
                
                directionsService[index] = new google.maps.DirectionsService;
                directionsDisplay[index] = new google.maps.DirectionsRenderer({
                  draggable: true,
                  map: map,
                  panel: document.getElementById('right-panel')
                });
  
                var request = {
                        origin: start,
                        destination: end,
                        travelMode: google.maps.TravelMode.DRIVING
                };
                directionsDisplay[index].addListener('directions_changed', function() {
                  computeTotalDistance(directionsDisplay[index].getDirections(),index);
                  $(".adp-directions").parent().attr('style','height:150px;overflow:auto');
                });

                displayRoute(request, directionsService[index],directionsDisplay[index]);

                 }, index * 1500);
                 

                    $(".adp-directions").parent().attr('style','height:150px;overflow:auto');
                    $("#map_view").css("height","400px");
                    $("#panel_right").show();

                  }
            });

                    return false;
            }else{
              $("#map_view").css("height","0");
              $("#panel_right").hide();
              $("#map").empty();
              $("#right-panel").empty();

            }
            /**/
        }

 function displayRoute(request, service, display) {

// var poly = new google.maps.Polyline({ map: map, strokeColor: '#4986E7' });

 
 
             service.route(request, function(response, status) {
              if (status == google.maps.DirectionsStatus.OK) {

                  display.setDirections(response);
                  display.setOptions( { suppressMarkers: true } );

              } else {
                console.log("Directions Request failed: " + status);
              }
            });
 
      }

      function computeTotalDistance(result,data_id) {
        var total = 0;
        var myroute = result.routes[0];
        // var overview_path_new = [];
        var lat = [];
        var lng = [];
         
        
 
         $( "input[name='TourPoint[overview_polyline][]']" ).each(function(){
                 var input = $(this).attr('data-id'); // This is the jquery object of the input, do what you will
                 if(input == data_id){
                  $(this).val(myroute.overview_polyline);
                  return false; 
                }   
            });

         for (var i = 0; i < myroute.overview_path.length; i++) {
          lat.push(myroute.overview_path[i].lat());
          lng.push(myroute.overview_path[i].lng());
          // overview_path_new.push(new google.maps.LatLng(myroute.overview_path[i].lat(),myroute.overview_path[i].lng()));
        }
        
 
          $( "input[name='TourPoint[overview_path][]']" ).each(function(){
                 var input = $(this).attr('data-id'); // This is the jquery object of the input, do what you will
                 if(input == data_id){
                  $(this).val(lat+"-|-"+lng);
                  return false; 
                }   
            });

        var via_waypoint = result.routes[0].legs[0].via_waypoint;

        for (var i = 0; i < myroute.legs.length; i++) {
          total += myroute.legs[i].distance.value;
        }

        
        total = total / 1000;
        document.getElementById('total').innerHTML = total + ' km';
        var explode = function(){
            $(".adp-directions").parent().attr('style','height:150px;overflow:auto');
            $("#map_view").css("height","400px");
            $("#panel_right").show(); 
        };
        setTimeout(explode,500);
      }

 

      function geolocate()
      {
        
        initAutocomplete();
        if (navigator.geolocation)
        {

          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }



  </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmBN7h98gmeBjTRVxItwpQImf6OaJ7Eoo&libraries=places&callback=initAutocomplete"
        async defer>
    </script>
        
