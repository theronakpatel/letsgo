<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PolyUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="poly-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    

    <?php // $form->field($model, 'otp')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'A' => 'Active', 'I' => 'Inactive', 'NV' => 'Not verified', 'B' => 'Blacklisted', ], ['prompt' => '']) ?>
    
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?php //$form->field($model, 'created_date')->textInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-danger' : 'btn btn-danger']) ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
