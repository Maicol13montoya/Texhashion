<?php
session_start();

require 'providers/Database.php';

$controller = 'IndexController';

if (!isset($_REQUEST['controller'])) {
	require "controllers/" . $controller . ".php";
	$controller = new $controller;
	$controller->index();
} else {
	$controller = ucfirst($_REQUEST['controller']) . 'Controller';
	$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : 'index';

	require "controllers/" . $controller . ".php";
	$controller = new $controller;

	call_user_func(array($controller, $method));
}
