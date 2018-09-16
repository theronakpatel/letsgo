<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
// use yii\bootstrap\Nav;
// use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\LoginAsset;

$asset = backend\assets\LoginAsset::register($this);
// public $basePath = '@webroot';

$baseUrl = $asset->baseUrl;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?= $baseUrl ?>/images/ic_map_marker_user.png"/>

    <?= Html::csrfMetaTags() ?>
    <!-- <script src="<?=$baseUrl?>/assets/js/jquery-1.11.0.min.js"></script> -->

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- <script>$.noConflict();</script> -->
</head>

<body class="login-body">

<div class="container">

<?php $this->beginBody() ?>
 
<!-- This is needed when you send requests via Ajax -->
<script type="text/javascript">
var baseurl = '';
</script>


 
    <?=$content?>
    
 
    </div>

<?php $this->endBody() ?>
</body>
 
</html>
<?php $this->endPage() ?>
