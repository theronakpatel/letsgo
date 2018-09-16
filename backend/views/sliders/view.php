<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Sliders */

$this->title = $model->slider_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sliders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sliders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->slider_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->slider_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'slider_id',
            'image',
            'position',
            'added_date',
        ],
    ]) ?>

</div>
