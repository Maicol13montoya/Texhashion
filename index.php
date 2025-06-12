<?php
session_start();
require_once 'providers/Database.php';

$controller = 'IndexController';

if (!isset($_REQUEST['controller'])) {
	require_once "controllers/" . $controller . ".php";
	$controller = new $controller;
	$controller->index();
} else {
	$controller = ucfirst($_REQUEST['controller']) . 'Controller';
	$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : 'index';
	require_once "controllers/" . $controller . ".php";

	$controller = new $controller;
	call_user_func(array($controller, $method));
}
