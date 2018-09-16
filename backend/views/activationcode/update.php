<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TblActivationcode */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tbl Activationcode',
]) . $model->activationcode_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tbl Activationcodes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->activationcode_id, 'url' => ['view', 'id' => $model->activationcode_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tbl-activationcode-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
