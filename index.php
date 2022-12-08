<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once('config.php');
require_once('connection.php');
require_once('routes.php');
require_once('models/model.php');
require_once('controllers/controller.php');
require_once('modules/module.php');
require_once('helper.php');
if (isset($_GET['controller']) && isset($_GET['action'])) {
	$controller = $_GET['controller'];
	$action     = $_GET['action'];
} else {
	$controller = 'pages';
	$action     = 'home';
}

print_view($controller,$action);

function hebdt($datetime_str){
	$date = new DateTime($datetime_str);
	return $date->format('d-m-Y H:i:s');
}
 
?>