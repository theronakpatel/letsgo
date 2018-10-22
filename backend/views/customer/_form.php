<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
 
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'message')->textArea() ?>
	
	<?= $form->field($model, 'device')->dropDownList(array('all' => 'All Devices', 'android' => 'Android devices', 'ios' => 'iOS devices'), ['prompt' => 'Select Device',]) ?>

    <div class="form-group">
        <?= Html::submitButton('Send Notification', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
