<?php

$realstr = str_replace("common","",dirname(__DIR__));
$https_ =  (isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS'] =='on')?'https://':'http://'; 
$str = str_replace("/var/www/html/","",$realstr);

return [
    'noreplayEmail' => 'no-replay@anythingxxx.com',
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'realPath' => $realstr,
    'uploadPath' => $realstr.'uploads/',
    'site_url' => $https_.$_SERVER['HTTP_HOST'].'/'.$str,
    'uploadURL' => $https_.$_SERVER['HTTP_HOST'].'/'.$str.'/uploads/',
];