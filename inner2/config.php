<?php


$config = array(
    'system_name'=>'mymvc',
    'cash_version'=>'1.0',
    'db_host'=>'localhost',
    'db_database'=>'newmvc',
    'db_user'=>'just',
    'db_password'=>'1234',

    'site_title'=>'רשת איי אל ביז',
    'session_prefix'=>'mymvc_',
    'base_url'=>'',
    'base_url_dir'=>'inner2',

    'email_sender'=>'info@ilbiz.co.il',
    'email_sender_name'=>'מנהל הרשת',
    'is_mobile'=>false,

);


$config['base_url'] = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];

$config['is_mobile'] = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);



