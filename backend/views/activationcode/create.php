<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TblActivationcode */

$this->title = Yii::t('app', 'Create Tbl Activationcode');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tbl Activationcodes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-activationcode-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
