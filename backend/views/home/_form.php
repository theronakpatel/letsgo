<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PolyUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="poly-user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'location')->textInput(['autofocus'=>'true','placeholder'=>'Search City','maxlength' => true,'id'=>'autocomplete','onFocus'=>'geolocate1()']) ?> 
        </div>
        <div class="col-lg-4">
           <?php echo  $form->field($model, 'city_name')->textInput([ 'id'=>'city_name','readonly' => 'readonly','autofocus'=>'true']) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'city_latitude')->textInput([ 'id'=>'city_latitude','readonly' => 'readonly','autofocus'=>'true']) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'city_longitude')->textInput([ 'id'=>'city_longitude','readonly' => 'readonly','autofocus'=>'true']) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'city_photo')->fileInput(['maxlength' => true]) ?>
            <?php if ($model->city_photo != "" && file_exists(Yii::$app->params['uploadPath'].'city/'. $model->city_photo)){?>
                <div class="form-group">
            Old File: <!--<img src="<?php //echo Yii::$app->params['uploadUrl'] ?>city/<?php //echo $model['city_photo'] ?>" height="100" width="100"> -->
	      <img src="<?=Yii::$app->params['uploadUrl'] ?>city/<?= $model['city_photo'] ?>" class="img_delete play-media-modal" data-val="<?=Yii::$app->params['uploadUrl'] ?>city/<?= $model['city_photo'] ?>">
                </div>
            <?php }?>

        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'status')->dropDownList(['active' => 'Active', 'inactive' => 'Inactive'], ['prompt' => '--Select--']) ?>
        </div>
    </div>
    
    
    <?php //$form->field($model, 'created_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        <?= Html::Button('Reset', ['class' => 'btn btn-default','id'=>'reset_all']) ?>
        

    </div>

    <?php ActiveForm::end(); ?>

</div>

<!-- Modal -->
<div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      
      <div class="modal-body" id="body_append" style="text-align: center;">
        
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
 
$this->registerJs(' 
 
  jQuery(document).ready(function(){
  
     $(\'#myModal\').on(\'hide.bs.modal\', function (e) {
        $(\'#body_append\').html(\'\');
      })
    var validator = jQuery("#w0").validationEngine({promptPosition: \'inline\',maxErrorsPerField:1});


  
  jQuery(document).on(\'click\',\'.add_new_media\',function(){
        


        var new_media_div = jQuery(\'#abc_here\').children().clone();
        jQuery(\'.append_media_here\').append(new_media_div);
        jQuery(".new_media_div").show();


        var count = $(\'.mediafiles\').length - 1;  

        $(\'.mediafiles\').each(function(index,value){
          $(this).attr(\'id\',\'abc\'+index);
        });
        
        validator.resetForm();
      });

      jQuery(document).on(\'click\',\'.play-media-modal\',function(){
      $(\'#body_append\').html(\'\');
      var type_value = $(this).attr(\'data-type\');  
      var val_value = $(this).attr(\'data-val\');

      if(type_value == \'audio\'){
        
        var htm = \'<audio controls style="width: 100%;">\'+
                    \'<source src="\'+val_value+\'" type="audio/mp3">\'+
                  \'</audio>\';

        $(\'#body_append\').html(htm);
        $(\'#myModal\').modal(\'show\');
      }
      else if(type_value == \'video\'){
        
        var htm = \'<video controls style="width: 100%;">\'+
                    \'<source src="\'+val_value+\'" type="video/mp4">\'+
                  \'</video>\';

        $(\'#body_append\').html(htm);
        $(\'#myModal\').modal(\'show\');
      }else{
        var htm = \'<img src="\'+val_value+\'" style="width:100%">\';
        $(\'#body_append\').html(htm);
        $(\'#myModal\').modal(\'show\');
      }
    });
      
      
      jQuery(document).on(\'click\',\'.remove_this_media\',function(){
        
        jQuery(this).parent().parent().parent().remove();
        validator.resetForm();
      });
    
    

});', \yii\web\View::POS_READY);
?>  
 <script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['(cities)'],componentRestrictions: {country: 'in'}
        });

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        // autocomplete.addListener('place_changed', fillInAddress);

         google.maps.event.addListener(autocomplete, 'place_changed', function () {
                  var place = autocomplete.getPlace();
                  // document.getElementById('locality').value = place.address_components[0].long_name;

                  document.getElementById('city_latitude').value = place.geometry.location.lat();
                  document.getElementById('city_longitude').value = place.geometry.location.lng();

                  //alert("This function is working!");
                  //alert(place.name);
                 // alert(place.address_components[0].long_name);

                  for (var i = 0; i < place.address_components.length; i++) {

                      var addressType = place.address_components[i].types[0];
                      
 
                      if (componentForm[addressType]) {
                        
                        var val = place.address_components[i][componentForm[addressType]];

                        
                        if(addressType == 'street_number' || addressType == 'route'){
                          console.log('Please provide city name only.');
                          
                          $('#autocomplete').val('');
                          $('#city_name').val('');
                          $('#city_latitude').val('');
                          $('#city_longitude').val('');
                          document.getElementById('city_name').value = '';
                        }

                        if(addressType == 'locality' ){
                          $('#city_name').val(val);
                        }

                        // document.getElementById(addressType).value = val;
                      }
                    }


                 // fillInAddress(place);

              });


      }

   

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgv8go-MadvI8rH99fVhGHKy0z7c0VJuo&libraries=places&callback=initAutocomplete"
        async defer></script>
        