
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'OTP';
// $this->site_label = 'Dear user, log in to access the admin area!';
$this->params['breadcrumbs'][] = $this->title;
$bUrl = Yii::$app->homeUrl;
?>
 

   <!-- <form class="form-signin" action="index.html"> -->

<?php $form = ActiveForm::begin(['id' => 'login-form','options' => ['class' => 'form-signin']]); ?>

<h2 class="form-signin-heading">
         <div>
            <a href="<?= Yii::$app->homeUrl ?>"><img width="120" alt="" src="Bandhan_Logo_main.png"></a>
         </div><br>
         <div>
            Enter OTP 
         </div>
         </h2>
 
          <?php if(Yii::$app->getSession()->getFlash('success') != '' || Yii::$app->getSession()->getFlash('error') != ''){ ?>
          <div class="">
              <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <?= Yii::$app->getSession()->getFlash('success') ; ?>
                <?= Yii::$app->session->getFlash('error'); ?>
              </div>
              </div>
          <?php } ?>


        <div class="login-wrap">
    	  <div class="user-login-info">
    		      <?= $form->field($model, 'phone', ['template' => '<div>
            {input}
              </div>{error}'])->textInput(['readonly' =>'readonly','class' => 'form-control']) ?>

             <?= $form->field($model, 'otp', ['template' => '<div>
    			  {input}
    		      </div>{error}'])->textInput(['autofocus' => true,'class' => 'form-control','placeholder' => 'Enter OTP sent to your phone']) ?>
    	      </div>
    	      <div>
    		  <input class="btn btn-danger submit" type="submit" name="" value="Verify OTP">
    		  <!-- <a class="btn btn-danger reset_pass" id="login" href="<?=$bUrl?>login">Back to Login Page</a>  -->
    	   </div>
        </div>

<?php ActiveForm::end(); ?>



            

           


            
 

          