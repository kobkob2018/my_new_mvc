<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once('a_core/config.php');
require_once('a_core/connection.php');
require_once('a_core/models/model.php');
require_once('a_core/controllers/controller.php');
require_once('a_core/modules/module.php');
require_once('a_core/helper.php');
require_once('a_core/helpers/helper.php');
require_once('a_core/helpers/view.php');
//now merge a_core config with system config!!
$system = isset($_REQUEST['system'])? $_REQUEST['system']: get_config('default_system');
require_once($system."/config.php");
foreach($system_config as $key=>$value){
    $config[$key] = $value;
}
//here is where the action begin
require_once('a_core/routes.php');



 
?>