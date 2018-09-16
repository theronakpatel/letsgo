<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Forgot Password';
// $this->site_label = 'Dear user, log in to access the admin area!';
$this->params['breadcrumbs'][] = $this->title;
$bUrl = Yii::$app->homeUrl;
?>
 <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['class' => 'form-horizontal']
                    ]); ?>
              <h1>Polycab App </h1>
              <h4>Reset Password </h4>
            <span style="color:red;"><?= Yii::$app->session->getFlash('success'); ?></span>


                <?= $form->field($model, 'admin_password', ['template' => '<div>
                        {input}
                    </div>{error}'])->textInput(['autofocus' => true,'type' => 'password','placeholder' => 'Type new password']) ?>

 
              <div>
                <?= Html::submitButton('Reset Password', ['class' => 'btn btn-default submit']) ?>
              </div>
 
                <?php ActiveForm::end(); ?>

          </section>
        </div>

      </div>
    </div>