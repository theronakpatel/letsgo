<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Reset Password';
// $this->site_label = 'Dear user, log in to access the admin area!';
$this->params['breadcrumbs'][] = $this->title;
$bUrl = Yii::$app->homeUrl;
?>
   <!-- <form class="form-signin" action="index.html"> -->

   <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['class' => 'form-signin'],
                    ]); 
    ?>
        <h2 class="form-signin-heading">
         <div>
            <a href="<?= Yii::$app->homeUrl ?>"><img width="120" alt="" src="<?=$bUrl?>hoi_logo.png"></a>
         </div><br>
         <div>
            Reset Password
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
                <?= $form->field($model, 'password', ['template' => ' <div>{input}</div>{error}'])->passwordInput(['autofocus' => true,'class' => 'form-control','placeholder' => 'Type your new password here','onkeyup' => "nospaces(this)",'value' => '']) ?>
                <?= $form->field($model, 'verify_password', ['template' => ' <div>{input}</div>{error}'])->passwordInput(['autofocus' => true,'class' => 'form-control','placeholder' => 'Retype your new password here','onkeyup' => "nospaces(this)",'value' => '']) ?>
            </div>
                <?= Html::submitButton('Reset Password', ['class' => 'btn btn-danger submit']) ?>
        </div>
                <?php ActiveForm::end(); ?>