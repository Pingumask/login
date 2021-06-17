<?php
require_once("../model/User.class.php");
session_start();
require_once("../function/routeMatch.php");
require_once("../controller/ErrorController.php");
require_once("../controller/HomeController.php");

$_URI=$_SERVER['REQUEST_URI'];
$_REQUEST=explode('?',$_URI);
$_ROUTE=$_REQUEST[0];
$_PARAMS=explode('/',$_ROUTE);
array_shift($_PARAMS);
$controller="../controller/".ucfirst(strtolower($_PARAMS[0]))."Controller.php";
if(file_exists($controller)){    
    require_once($controller);
}

require_once("../controller/routes.php");