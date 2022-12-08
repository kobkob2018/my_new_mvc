<?php

function get_config($param){
    global $config;
    return $config[$param];
}

function session__isset($param_name){
    $session_prefix = get_config('session_prefix');
    $session_param = $session_prefix.$param_name;
    return isset($_SESSION[$session_param]);
}



function session__set($param_name,$param_val){
    $session_prefix = get_config('session_prefix');
    $session_param = $session_prefix.$param_name;
    $_SESSION[$session_param] = $param_val;
}


function session__unset($param_name){
    $session_prefix = get_config('session_prefix');
    $session_param = $session_prefix.$param_name;
    unset($_SESSION[$session_param]);
}



function session__get($param_name,$param_val){
    $session_prefix = get_config('session_prefix');
    $session_param = $session_prefix.$param_name;
    return $_SESSION[$session_param];
}

function inner_url($url = ''){
    $base_url_dir = get_config('base_url_dir');
    $base_url_dir_after = '';
    $base_url_dir_before = '';
    if($base_url_dir != ''){
        $base_url_dir_after = '/';
    }
    $url = $base_url_dir.$base_url_dir_after.$url;
    if($url != ''){
        $base_url_dir_before = '/';
    }
    return $base_url_dir_before.$url;
}

function outer_url($url = ''){
    $base_url = get_config('base_url');
    $inner_url = inner_url($url);
    return $base_url.$inner_url;
}

function is_mobile(){    
    return get_config('is_mobile');
}