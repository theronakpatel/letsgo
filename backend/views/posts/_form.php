<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TblPosts */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      
      /* Optional: Makes the sample page fill the window. */
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
    </style>

<div class="tbl-posts-form">

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="form-group col-lg-6">
            <?= $form->field($model, 'name')->textInput() ?>
    </div>
</div>
<div class="row">

    <div class="form-group col-lg-6">
            <?= $form->field($model, 'description')->textArea() ?>
    </div>
    <div class="form-group col-lg-6">
            <?= $form->field($model, 'category_id')->dropDownList($categories, ['prompt' => 'Select Category',]) ?>
    </div>
    
</div>
<div class="pac-card" id="pac-card">
  <div>
    <div id="title">
      Autocomplete search
    </div>
    
  </div>
  <div id="pac-container">
    <input id="pac-input" type="text"
        placeholder="Enter a location">
  </div>
</div>
<div id="map"></div>
<div id="infowindow-content">
  <img src="" width="16" height="16" id="place-icon">
  <span id="place-name"  class="title"></span><br>
  <span id="place-address"></span>
</div>
<br>
<label style="color:red">You can search location from above Google map. It will autocomplete Address, Latitude and Longitude.</label>
<div class="row">
    <div class="form-group col-lg-6">
            <?= $form->field($model, 'address')->textArea() ?>
    </div>
    <div class="form-group col-lg-3">
            <?= $form->field($model, 'latitude')->textInput() ?>
    </div>
    <div class="form-group col-lg-3">
            <?= $form->field($model, 'longitude')->textInput() ?>
    </div>
</div> 
<div class="row">
    <div class="form-group col-lg-6">
      
        <?= $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>
        <?php if ($model->image != "" && file_exists(Yii::$app->params['uploadPath'].'posts/'. $model->image)){?>
            <div class="form-group col-lg-6">
        Old File: 
           <img src="<?=Yii::$app->params['uploadURL'] ?>posts/<?= $model['image'] ?>" class="img_delete play-media-modal" data-val="<?=Yii::$app->params['uploadURL'] ?>posts/<?= $model['image'] ?>">
            </div>
        <?php }?>

    </div>    
</div>
<div class="row">
    <div class="form-group col-lg-6">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>
</div>
    <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 23.8859, lng:  45.0792},
          zoom: 6
        });
        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(
            ['address_components', 'geometry', 'icon', 'name']);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        var posts_latitude = $('#posts-latitude').val();
        var posts_longitude = $('#posts-longitude').val();
        if(posts_latitude != '' && posts_longitude != '' ){
            map.setCenter(new google.maps.LatLng(posts_latitude,posts_longitude));
            marker.setPosition(new google.maps.LatLng(posts_latitude,posts_longitude));
            marker.setVisible(true);
        }

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }
          infowindowContent.children['place-icon'].src = place.icon;
          infowindowContent.children['place-name'].textContent = place.name;
          infowindowContent.children['place-address'].textContent = address;
          $('#posts-address').val(address);
          $('#posts-latitude').val(place.geometry.location.lat());
          $('#posts-longitude').val(place.geometry.location.lng());

          infowindow.open(map, marker);
        });

      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwt5yWaobFK3ce76BXSbjNYzlFygp_ADo&libraries=places&callback=initMap&language=ar-AR"
        async defer></script>
