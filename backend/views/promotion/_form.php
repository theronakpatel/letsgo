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
        <div class="col-lg-6">
            <?= $form->field($model, 'name')->textInput(['autofocus'=>'true','placeholder'=>'Promotion Name' ]) ?> 
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'description')->textInput(['autofocus'=>'true','placeholder'=>'Promotion description' ]) ?> 
        </div>
        
    </div>
    
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>
            <?php if ($model->image != "" && file_exists(Yii::$app->params['uploadPath'].'promotion/'. $model->image)){?>
                <div class="form-group">
            Old File: 
	           <img src="<?=Yii::$app->params['uploadURL'] ?>promotion/<?= $model['image'] ?>" class="img_delete play-media-modal" data-val="<?=Yii::$app->params['uploadURL'] ?>promotion/<?= $model['image'] ?>">
                </div>
            <?php }?>

        </div>
        
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        <?= Html::Button('Reset', ['class' => 'btn btn-default','id'=>'reset_all']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
