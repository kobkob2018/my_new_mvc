<?php


$config = array(
    'system_name'=>'mymvc',
    'cash_version'=>'1.0',
    'db_host'=>'localhost',
    'db_database'=>'newmvc',
    'db_user'=>'just',
    'db_password'=>'1234',

    'default_system'=>'sites',
    'site_title'=>'רשת איי אל ביז',
    'session_prefix'=>'mymvc_',
    'base_url'=>'',
    'base_url_dir'=>'usites',

    'error_controller'=>'pages',
    'error_action'=>'error',

    'handle_access_default'=>'login_only',
    'home_controller'=>'pages',
    'home_action'=>'home',

    'email_sender'=>'info@ilbiz.co.il',
    'email_sender_name'=>'מנהל הרשת',
    'is_mobile'=>false,

    'a_core_models'=>array('userLogin','users','systemMessages','globalSettings','sites','pages','test'),
    'override_models'=>array(),
    'access_module'=>'main',
);


$config['base_url'] = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];

$config['is_mobile'] = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);



