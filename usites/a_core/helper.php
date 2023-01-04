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
    if(isset($_SESSION[$session_param])){
        return $_SESSION[$session_param];
    }
    else{
        return null;
    }
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
    
    $url_arr = array();

    $base_url_dir = get_config('base_url_dir');

    if($base_url_dir != ''){
        $url_arr['dir'] = $base_url_dir;
    }

    if(isset($_REQUEST['system'])){
        $url_arr['system'] = $_REQUEST['system'];
    }

    if($url != ''){
        $url_arr['url'] = $url;
    }
    $final_url = "";
    $ending_slash = "";
    foreach($url_arr as $part){
        if($url == ''){
            $ending_slash = "/";
        }
        $final_url.= "/".$part;
    }
    $final_url.= $ending_slash;

    return $final_url;

}


function outer_url($url = ''){
    $base_url = get_config('base_url');
    $inner_url = inner_url($url);
    return $base_url.$inner_url;
}

function current_url($add_params = array()){
    $base_url = get_config('base_url');
    $current_url = $base_url . $_SERVER["REQUEST_URI"];
    if(!empty($add_params)){
        $current_url_arr = explode("?",$current_url);
        $add_params_str_arr = array();
        if(isset($current_url_arr[1])){
            $add_params_str_arr[] = $current_url_arr[1];
        }
        foreach($add_params as $key=>$value){
            $add_params_str_arr[] = "$key=$value";
        }
        $add_params_str = implode("&",$add_params_str_arr);
        $current_url = $current_url_arr[0]."?".$add_params_str;
    }
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

function system_path($file_path){
    if(isset($_REQUEST['system'])){
        return $_REQUEST['system']."/".$file_path;
    }
    else{
        return get_config("default_system")."/".$file_path;
    }
}

function system_require_once($file_path){
    require_once(system_path($file_path));
}

function system_file_exists($file_path){
    return file_exists(system_path($file_path));
}

function print_r_help($val,$name = 'the-field'){
    echo "<hr>".$name."<hr><pre style='direction:ltr; text-align:left;'>";
    print_r($val);
    echo "</pre><hr>";
}

function var_dump_help($val,$name = 'the-field'){
    echo "<hr>".$name."<hr><pre style='direction:ltr; text-align:left;'>";
    var_dump($val);
    echo "</pre><hr>";
}

function print_help($str,$name = 'the-field'){
    echo "<hr>".$name.': '.$str."<hr>";
}