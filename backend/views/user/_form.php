
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PolyUser */
/* @var $form yii\widgets\ActiveForm */

$asset = backend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

?>

<div class="poly-user-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'name')->textInput(['autofocus'=>'true','maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'phone')->textInput(['autofocus'=>'true','maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'status')->dropDownList([ 'A' => 'Active', 'I' => 'Inactive'], ['prompt' => '--Select--']) ?>
        </div>
        <div class="col-lg-4">
             <?php echo $form->field($model, 'language_id')->dropDownList($model->languagelist,['prompt'=>'-Choose a language-']) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4">
            <?php echo $form->field($model, 'access_type')->dropDownList([ '0' => 'Live', '1' => 'Live+Beta', '2' => 'Beta'], ['prompt' => '--Select--']) ?>
        </div>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        <?= Html::Button('Reset', ['class' => 'btn btn-default','id'=>'reset_all']) ?>
        

    </div>

    <?php ActiveForm::end(); ?>

</div>
