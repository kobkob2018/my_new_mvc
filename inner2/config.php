<?php


$config = array(
    'system_name'=>'myleads',

    'db_host'=>'localhost',
    'db_database'=>'newmvc',
    'db_user'=>'just',
    'db_password'=>'1234',

    'session_prefix'=>'myleads_',
    'base_url'=>'',
    'base_url_dir'=>'inner2',

    'is_mobile'=>false,

);


$config['base_url'] = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];

$config['is_mobile'] = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);



