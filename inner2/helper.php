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
    //echo "<br/>session adding".$session_param."===".$param_name."<br/>";
    $_SESSION[$session_param] = $param_val;
}


function session__unset($param_name){
    $session_prefix = get_config('session_prefix');
    $session_param = $session_prefix.$param_name;
    unset($_SESSION[$session_param]);
}



function session__get($param_name){
    $session_prefix = get_config('session_prefix');
    $session_param = $session_prefix.$param_name;
    return $_SESSION[$session_param];
}

function session__clear(){
    foreach($_SESSION as $key=>$val){
        if(strpos($key, get_config('session_prefix')) === 0){
            unset($_SESSION[$key]);
        }       
    }
}

function session__clear_all(){
    foreach($_SESSION as $key=>$val){
        unset($_SESSION[$key]);
    }
}

function create_session_id(){
    $ss1  = time();
    $ss1 = str_replace(":",3,$ss1); 
    $ss2 = $_SERVER['REMOTE_ADDR'];
    $ss2 = str_replace(".",3,$ss2); 
    $sesid = "$ss2$ss1";
    return $sesid;
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

function current_url(){
    $base_url = get_config('base_url');
    $current_url = $base_url . $_SERVER["REQUEST_URI"];
    return $current_url;
}

$current_url = get_config('base_url') . $_SERVER["REQUEST_URI"];

function is_mobile(){    
    return get_config('is_mobile');
}

function input_protect($val){
    return $val;
}

function hebdt($datetime_str){
	$date = new DateTime($datetime_str);
	return $date->format('d-m-Y H:i:s');
}