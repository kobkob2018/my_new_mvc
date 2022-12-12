<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once('config.php');
require_once('connection.php');
require_once('models/model.php');
require_once('controllers/controller.php');
require_once('modules/module.php');
require_once('helper.php');

//here is where the action begin
require_once('routes.php');



 
?>