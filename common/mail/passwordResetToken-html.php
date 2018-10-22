<?php
use yii\helpers\Html;
$site_url = Yii::$app->params['site_url'];
$resetLink = $site_url.'backend/login/resetpassword?token='.$password_reset_token;
?>
<div class="password-reset">
    <p>Hello <?=$name ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
