<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Login';
// $this->site_label = 'Dear user, log in to access the admin area!';
$this->params['breadcrumbs'][] = $this->title;
$bUrl = Yii::$app->homeUrl;
?>

   <!-- <form class="form-signin" action="index.html"> -->

   <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['class' => 'form-signin'],
                         'enableAjaxValidation'=>true,
                    ]); 

          $form->enableClientValidation=false;
          $form ->enableAjaxValidation=false;
?>
         <h2 class="form-signin-heading">
         <div>
            <a href="<?= Yii::$app->homeUrl ?>"><img width="120" alt="" src="<?=$bUrl?>logo.png"></a>
         </div><br>
         <div>
            sign in 
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
              <?= $form->field($model, 'email', ['template' => '<div>
                        {input}
                    </div>{error}'])->textInput(['autofocus' => true,'type' => 'email','class' => 'form-control','placeholder' => 'Type your email here','onkeyup' => "nospaces(this)"]) ?>


                <?= $form->field($model, 'password', ['template' => ' <div>{input}</div>{error}'])->passwordInput(['autofocus' => true,'class' => 'form-control','placeholder' => 'Type your password here','onkeyup' => "nospaces(this)"]) ?>
            </div>
               <!-- <input type="checkbox" value="remember-me"> Remember me-->
               <!--  <span class="pull-right">
                    <a href="<?=$bUrl?>login/forgot" id="forget_password"> Forgot Password ?</a>
                </span> -->
                <br>
            <button class="btn btn-lg btn-login btn-block" type="submit" id="signin" >Sign in</button>

           <!--  <div class="registration">
                Don't have an account yet?
                <a class="" href="registration.html">
                    Create an account
                </a>
            </div> -->

        </div>

          <!-- Modal -->
          <!-- <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Forgot Password ?</h4>
                      </div>
                      <div class="modal-body">
                          <p>Enter your e-mail address below to reset your password.</p>
                          <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                      </div>
                      <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                          <button class="btn btn-success" type="button">Submit</button>
                      </div>
                  </div>
              </div>
          </div> -->
          <!-- modal -->  

                <?php ActiveForm::end(); ?>
 

           

<script type="text/javascript">
// function nospaces(t){
// if(t.value.match(/\s/g)){
// swal('Sorry, you are not allowed to enter any spaces');
// t.value=t.value.replace(/\s/g,'');
// }
// }

</script>