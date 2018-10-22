<?php

$realstr = str_replace("common","",dirname(__DIR__));
$https_ =  (isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS'] =='on')?'https://':'http://'; 
$str = str_replace("/var/www/html/","",$realstr);

return [
    'noreplayEmail' => 'no-replay@letsgo.com',
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'ANDROID_API_KEY' => 'AAAAswq--xI:APA91bHS_NqwwJHp9kfeU-STvBsHMLLZJrEuMAG0R094hw6Iz5pKCXevkJddNE9yLSOuhXyL_tEB4BXle0wEBbGeRY0aqJynu_jDr6EtNs9v68lnlg0PIqoIpwYR77xeE6oodlY9jRFG',
    'realPath' => $realstr,
    'uploadPath' => $realstr.'uploads/',
    'site_url' => $https_.$_SERVER['HTTP_HOST'].'/'.$str,
    'uploadURL' => $https_.$_SERVER['HTTP_HOST'].'/'.$str.'/uploads/',
];