<?php
      
    //metodo para iniciar una sesion en el navegador  
    session_start();  

	require 'providers/Database.php';
     //el primer controlador por abrir siempre es el logincontroller
	$controller = 'IndexController';

	if(!isset($_REQUEST['controller'])) {
		require "controllers/" . $controller . ".php";

		$controller = ucwords($controller);
		$controller = new $controller;
		$controller->index();		
	} else {
		$controller = ucwords($_REQUEST['controller'].'Controller');
		//Condicional Ternario   condición       Si es Verdad         Si es Falso
		$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : 'index';

		require "controllers/". $controller	.".php";
		$controller = new $controller;

		//Función para llamar al controlados y ejecutar el metodo.
		call_user_func(array($controller, $method));
	}