<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TblCountries */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tbl Countries',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tbl Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->country_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tbl-countries-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
