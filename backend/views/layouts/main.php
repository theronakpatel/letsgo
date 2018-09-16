<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
// use yii\bootstrap\Nav;
// use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;

$asset = backend\assets\AppAsset::register($this);
// public $basePath = '@webroot';

$bUrl = Yii::$app->homeUrl;
// print_r(Yii::$app->homeUrl);exit;

$baseUrl = $asset->baseUrl;


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?= $baseUrl ?>/images/ic_map_marker_user.png"/>
    <!-- <link rel="shortcut icon" type="image/png" href=""/> -->
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">

    
    <?= Html::csrfMetaTags() ?>
    <!-- <script src="<?=$baseUrl?>/assets/js/jquery-1.11.0.min.js"></script> -->

    <title><?= Html::encode($this->title) ?></title>
    <script>
   var bUrl = '<?=$baseUrl ?>/';
   </script>
    <?php $this->head() ?>

    <style>
    .mini-stat-info span {
        font-size: 22px !important;
    }
    .mini-stat{
      padding: 10px !important;
    }
    .tour_div_main  #kv-grid-demo{
        width: 130%;
    }

    .tour_div_main  #products-container{
        max-width: 100%;
        overflow: auto;
    }

    .ui-widget-header {
      border: 1px solid #118686 !important;
      color: #fff !important;
      font-weight: bold !important;
      background-color: #118686 !important;
      background-image: none !important;
  }
  .ui-dialog-titlebar-close{
    display: none;
  }
  audio,video{
    width: 100% !important;
  }

    #note{
      background: rgba(128, 128, 128, 0.2);
      margin-bottom: 10px;
    }
      #right-panel {
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
        max-height: 400px;
        overflow: auto;
      }
      .marbottom10{
        margin-bottom: 10px;
      }
      #right-panel select, #right-panel input {
        font-size: 15px;
      }

      #right-panel select {
        width: 100%;
      }

      #right-panel i {
        font-size: 12px;
      }

      #map {
        height: 400px;
        width: 100%;
      } 
      #right-panel td{
            max-width: 185px !important;
      }
      .img_delete_video
      {
        position: absolute;
        height: 30px;
        width: 30px;
        top: 25%;
        left: 35%;
      }
      
      .img_delete_video_uploaded_media
      {
        position: absolute;
        height: 30px;
        width: 30px;
        top: 25%;
        left: 30%;
      }
      
      .img_delete_video_at_media
      {
        position: absolute;
        height: 30px;
        width: 30px;
        top: 25%;
        left: 50%;
      }
      
    </style>


    <style type="text/css">
    .play-media-modal{
      cursor: pointer;
    }
    img.img_delete {
        width: 80px;
        height: 80px;
    }
    .new_img_delete {
        width: 100%;
        height: 60px;
    }
    .5px7{
      padding: 5px 7px !important;
      font-size: 12px !important;
    }
     *{
          word-wrap: break-word;
     } 
     .padding0{
      padding: 0;
     }
    .deleteImage {
        position: absolute;
        right: 17%;
        padding: 2px 5px;
        line-height: 1;
        background-color: rgba(255, 0, 0, 0.5) !important;
        border: rgba(255, 0, 0, 0.34) !important;
    }

     .border-dotted {
          border: 1px dashed #d4d4d4;
      }

     .martop10{
      margin-top: 10px;
     }
     .margin0{
      margin:0;
     }
  .daterangepicker .calendar.single .calendar-date {
      border: none;
      display: none;
  }
  form div.required label.control-label:after {
    content:" * ";
    color:red;
  }

  table td a {
      display: table-cell;
  }
  .btn-danger {
    color: #fff;
    background-color: #d9534f;
    border-color: #d43f3a;
}
.pagination > li > a:hover, .pagination > li > span:hover, .pagination > li > a:focus, .pagination > li > span:focus, .pagination > li.active > a, .pagination > li.active > a:hover {
    background-color: #ed3237;
    border-color: #ed3237;
    color: #fff;
}

.pagination > li > a, .pagination > li > span {
    background-color: #ffffff;
    border: 1px solid #dddddd;
    float: left;
    line-height: 1.42857;
    margin-left: 1px;
    padding: 6px 12px;
    position: relative;
    text-decoration: none;
}

.no-padding{
  padding: 0;
}
.table td{
  /*text-transform: capitalize;*/
}

.panel-body .form-group {
    /*width: 40%;*/
}
td
{
  max-width: 100px;
  word-wrap: break-word;
  text-overflow: ellipsis;
  overflow: hidden;
}
.summary{
  font-size: 14px;
}


.ui-button-text-only .ui-button-text {
    padding: .4em 1em;
    background: #d9534f;
    border-color: #d9534f;
}
.panel-footer
{
    /*display:none;*/
}

tr{
  border: 1px solid #ddd;
}



    </style>
    <!-- <script>$.noConflict();</script> -->


    <style type="text/css">
.shout_box {
  background: #ed3237;
  width: 260px;
  overflow: hidden;
  position: fixed;
  bottom: 0;
  right: 2%;
  z-index:9;
  border: 2px solid #ed3237;
  border-bottom: 0;
} 

.shout_box .header{
  padding: 5px 3px 5px 5px;
  font: 11px 'lucida grande', tahoma, verdana, arial, sans-serif;
  font-weight: bold;
  color:#000;
  border: 1px solid #ed3237;
  height: 25px;
  border-bottom:none;
  background: #ed3237;
  cursor: pointer;
}
.shout_box .header:hover{
  background-color: #ed3237;
}
.shout_box .message_box {
  background: #FFFFFF;
  /*height: 200px;*/
  overflow: hidden;
  border: 1px solid #CCC;
}
.shout_msg{
  margin-bottom: 10px;
  display: block;
  border-bottom: 1px solid #F3F3F3;
  padding: 0px 5px 5px 5px;
  font: 11px 'lucida grande', tahoma, verdana, arial, sans-serif;
  color:#7C7C7C;
}
.message_box:last-child {
  border-bottom:none;
}

time{
  font: 11px 'lucida grande', tahoma, verdana, arial, sans-serif;
  font-weight: normal;
  float:right;
  color: #D5D5D5;
}
.shout_msg .username{
  margin-bottom: 10px;
  margin-top: 10px;
}
.user_info input {
  width: 98%;
  height: 25px;
  border: 1px solid #CCC;
  border-top: none;
  padding: 3px 0px 0px 3px;
  font: 11px 'lucida grande', tahoma, verdana, arial, sans-serif;
}
.shout_msg .username{
  font-weight: bold;
  display: block;
}

</style>
<style>
/* Center the loader */
#loader {

  position: fixed;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid rgb(228, 228, 228);
  border-radius: 50%;
  border-top: 16px solid #118686;
  border-bottom: 16px solid #118686;

  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}
.deleteImage_tour,.deleteImage_location{
  padding: 0px 5px !important;
  position: absolute !important;
  right: 50px !important;
}
</style>
</head>

<body class="nav-md">
<section id="container">


<?php $this->beginBody() ?>
 
 
    <?= $this->render('sidebar.php',['baseUrl'=>$baseUrl,'bUrl'=>$bUrl]); ?>
    <?= $this->render('content.php',['baseUrl'=>$baseUrl,'bUrl'=>$bUrl]); ?>
    <?php echo $content; ?>
    
<?php // $this->render('models.php',['baseUrl'=>$baseUrl,'bUrl'=>$bUrl]); ?>
<?= $this->render('footer.php',['baseUrl'=>$baseUrl,'bUrl'=>$bUrl]); ?>
 


<?php $this->endBody() ?>
</section>

<div id="loader" style="display:none"></div>


<script type="text/javascript">
 
 var idleTime = 0;
$(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip();
    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute
     //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
        
    });
    $(this).keypress(function (e) {
        idleTime = 0;
        
    });
});

function timerIncrement() {
    idleTime = idleTime + 1;
        
    if (idleTime > 30) { // 30 minutes
        alert('Logged out due to session timeout!');
        location.href = "<?=$bUrl.'site/logout' ?>";


    }
}
  $( document ).ajaxStart(function() {
  
      $('#loader').show();
});
 
 $( document ).ajaxStop(function() {
  $( "#loader" ).hide();
  
});

 
$(document).on('pjax:start', function(e) {
      
      $('#loader').show();
  });
$(document).on('pjax:end', function(e) {
     $('#loader').hide();
      
  });
    
    $(document).on('click','#reset_all',function(){
      $('input[type=text]').val('');
      $('input[type=file]').val('');
//    $("input[type=text]")[0].attr('autofocus','true');
      $('select').val('');
      location.href = location.href
    }); 
   
   $(document).on('click','#logout_click',function(){
       
        var user_type = '<?= Yii::$app->session->get('user_type');  ?>';
         if(user_type == 'Ex'){
             var popper= window.open('https://192.168.1.105/call3/?id='+btoa(user_id)+'&pass='+btoa(sip_password),'call','resizable,height=260,width=370');
             popper.close();   // Closes the new window             
         }

    }); 
 
    
     $(function(){
  
      
        
    $('#reportsearch-created_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    });
    

     $(function(){

    $('#loyaltysearch-created_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    
    });
    
    
    $(function(){

      $(document).keydown(function(e) {
          if (e.keyCode == 27 || (e.keyCode == 13 && e.target.nodeName != "TEXTAREA")) return false;
      });


      $('.fTab').on('click', function(){
      $(this).html($(this).html() == '+' ? '-' : '+');
          $(this).toggleClass('active');
      });

      $("body").on("keyup", function(e){
          if (e.which === 27){
            
              return false;
          } 
      });



  })
     

      $("body").on("keyup", function(e){
          if (e.which === 27){
            
              return false;
          } 
      });
    $(document).on('change','.changedVal',function(){

        var user_id = $(this).attr('data-id');
        var status = $(this).val();
        
        $.ajax({
            url: '<?=$bUrl.'poly-user/updatestatus' ?>',
            type: "post",
            data: {'user_id': user_id,'status':status },
                 success:function(data){
      //               alert('Status changed successfully');
                      $('#message_here').slideDown('slow');
                      var explode = function(){
                          $('#message_here').slideUp('slow');
                       };
                        setTimeout(explode,1500);
                  },
        });
    
    });

 
   $(document).on('change','.changedAdmin',function(){

        var user_id = $(this).attr('data-id');
        var status = $(this).val();
        
        $.ajax({
      url: '<?=$bUrl.'admin/updatestatus' ?>',
      type: "post",
      data: {'user_id': user_id,'status':status },
           success:function(data){
//               alert('Status changed successfully');
                $('#message_here').slideDown('slow');
                var explode = function(){
                    $('#message_here').slideUp('slow');
                 };
                  setTimeout(explode,1500);
            },
  });
    
    });
    $(document).on('change','.changedCity',function(){
        var city_id = $(this).attr('data-id');
        var status = $(this).val();
        
        $.ajax({
      url: '<?=$bUrl.'city/updatestatus' ?>',
      type: "post",
      data: {'city_id': city_id,'status':status },
           success:function(data){

//               alert('Status changed successfully');
                $('#message_here').slideDown('slow');

                var explode = function(){
                    $('#message_here').slideUp('slow');
                 };
                  setTimeout(explode,1500);
            },
  });
    });
    

    $(document).on('change','.changedPlace',function(){
        var place_id = $(this).attr('data-id');
        var status = $(this).val();
        
        $.ajax({
            url: '<?=$bUrl.'place/updatestatus' ?>',
            type: "post",
            data: {'place_id': place_id,'status':status },
                 success:function(data){

      //               alert('Status changed successfully');
                      $('#message_here').slideDown('slow');

                      var explode = function(){
                          $('#message_here').slideUp('slow');
                       };
                        setTimeout(explode,1500);
                  },
        });
    });

    
    $(document).on('change','.changedPlace',function(){
        var place_id = $(this).attr('data-id');
        var status = $(this).val();
        
        $.ajax({
            url: '<?=$bUrl.'place/updatestatus' ?>',
            type: "post",
            data: {'place_id': place_id,'status':status },
                 success:function(data){

      //               alert('Status changed successfully');
                      $('#message_here').slideDown('slow');

                      var explode = function(){
                          $('#message_here').slideUp('slow');
                       };
                        setTimeout(explode,1500);
                  },
        });
    });
    
    $(document).on('change','.changedLocation',function(){
        var location_id = $(this).attr('data-id');
        var status = $(this).val();
        
        $.ajax({
            url: '<?=$bUrl.'location/updatestatus' ?>',
            type: "post",
            data: {'location_id': location_id,'status':status },
                 success:function(data){

      //               alert('Status changed successfully');
                      $('#message_here').slideDown('slow');

                      var explode = function(){
                          $('#message_here').slideUp('slow');
                       };
                        setTimeout(explode,1500);
                  },
        });
    });
    
    $(document).on('change','.changedTour',function(){
        var tour_id = $(this).attr('data-id');
        var status = $(this).val();
        
        $.ajax({
      url: '<?=$bUrl.'tour/updatestatus' ?>',
      type: "post",
      data: {'tour_id': tour_id,'status':status },
           success:function(data){

//               alert('Status changed successfully');
                $('#message_here').slideDown('slow');

                var explode = function(){
                    $('#message_here').slideUp('slow');
                 };
                  setTimeout(explode,1500);
            },
  });
    });



    jQuery(document).ready(function(){
    
      // jQuery(document).on('click','#add_new_route',function(){
        
      //   jQuery("#append_here").append(jQuery("#copy_this").clone());
      // });

      
     /* jQuery(document).on('click','.add_new_media',function(){
        


        var new_media_div = jQuery('#abc_here').children().clone();
        jQuery(this).parent().parent().parent().find('.append_media_here').append(new_media_div);
        
        jQuery(".new_media_div").show();
        
      });

      jQuery(document).on('click','.remove_this_media',function(){
        
        jQuery(this).parent().parent().parent().remove();
      });*/

  });
    
    
    
      $(document).on("click",".deleteImage_location",function(e){
          e.preventDefault();

          var _this = $(this);

          var r = confirm("Are you sure want to delete image permanantly?");
          if (r == true) {
              var media_id = $(this).attr('data-id');
               
              $.ajax({
                url: '<?=$bUrl?>location/deleteimage',
                type: "post",
                data: {'media_id': media_id},
                success:function(data){
                  _this.parent().slideUp('1000');

                },
            });

              
          }

      });
      
      $(document).on("click",".deleteImage_tour",function(e){
          e.preventDefault();

          var _this = $(this);

          var r = confirm("Are you sure want to delete image permanantly?");
          if (r == true) {
              var media_id = $(this).attr('data-id');
               
              $.ajax({
                url: '<?=$bUrl?>tour/deleteimage',
                type: "post",
                data: {'media_id': media_id},
                success:function(data){
                  _this.parent().parent().slideUp('1000');

                },
            });

              
          }

      });
      
      $(document).on("click",".deleteImage_route",function(e){
          e.preventDefault();

          var _this = $(this);

          var r = confirm("Are you sure want to delete image permanantly?");
          if (r == true) {
              var media_id = $(this).attr('data-id');
               
              $.ajax({
                url: '<?=$bUrl?>route/deleteimage',
                type: "post",
                data: {'media_id': media_id},
                success:function(data){
                  _this.parent().parent().slideUp('1000');

                },
            });

              
          }

      });
      $(document).on("click",".delete_this_media",function(e){
          e.preventDefault();

          var _this = $(this);

          var r = confirm("Are you sure want to delete image permanantly?");
          if (r == true) {
              var media_id = $(this).attr('data-id');
               
              $.ajax({
                url: '<?=$bUrl?>tour-point/deleteimage',
                type: "post",
                data: {'media_id': media_id},
                success:function(data){
                  _this.parent().parent().slideUp('1000');

                },
            });

              
          }

      });
      
       jQuery(document).ready(function(){
                     $('#messages').slideDown('slow');

                var explode = function(){
                    $('#messages').slideUp('slow');
                 };
                  setTimeout(explode,1500);
        });
      
      // TimePicker
     
        jQuery(document).ready(function(){
          // jQuery(".time_element").timepicki({show_meridian:false, start_time: ["00","00"] });
        });

</script>

</body>
</html>
<?php $this->endPage() ?>
