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
    <hr>
      <label style="color:red">Add Posts and Categories from below lists to which this promotion will be applied for.
        <br>
        If you select any category from the list, promotion will be applied for all posts of that category automatically.
      </label>
    <hr>
    <div class="row">
        <div class="col-lg-6">
          <b>Add Posts</b> (Press CTRL key to select multiple options)
            <?php echo $form->field($model, 'posts')
                 ->dropDownList($model->PostDropdown(),
                 [
                  'multiple'=>'multiple',
                  'style' => 'width: 50%',
                  'class'=>'chosen-select input-md required',              
                 ]             
                )->label(false);  ?> 
        </div>
        <div class="col-lg-6">
          <b>Add Categories</b> (Press CTRL key to select multiple options)
            <?php echo $form->field($model, 'categories')
                 ->dropDownList($model->CategoryDropdown(),
                 [
                  'multiple'=>'multiple',
                  'style' => 'width: 50%',
                  'class'=>'chosen-select input-md required',              
                 ]             
                )->label(false);  ?> 
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        <?= Html::Button('Reset', ['class' => 'btn btn-default','id'=>'reset_all']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
