<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once('core/config.php');
require_once('core/connection.php');
require_once('core/models/model.php');
require_once('core/controllers/controller.php');
require_once('core/modules/module.php');
require_once('core/helper.php');

//now merge core config with system config!!
$system = isset($_REQUEST['system'])? $_REQUEST['system']: get_config('default_system');
require_once($system."/config.php");
foreach($system_config as $key=>$value){
    $config[$key] = $value;
}

//here is where the action begin
require_once('core/routes.php');



 
?>