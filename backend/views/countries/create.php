<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TblCountries */

$this->title = Yii::t('app', 'Create Tbl Countries');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tbl Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-countries-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
