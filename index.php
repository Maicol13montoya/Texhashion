<?php
session_start();
require_once 'providers/Database.php';

$defaultController = 'IndexController';
$defaultMethod = 'index';

// Lista blanca de controladores permitidos
$allowedControllers = [
    'IndexController',
    'LoginController',
    'FacturasController',
    'UsuariosController',
    'MateriaprimaController',
    'OrdenesController',
    'ProductosTerminadosController',
    'CorreoController',
    'HomeController'
];

// Obtener controlador y método desde la URL
$controllerName = isset($_REQUEST['controller']) 
    ? ucfirst($_REQUEST['controller']) . 'Controller' 
    : $defaultController;

$method = isset($_REQUEST['method']) 
    ? $_REQUEST['method'] 
    : $defaultMethod;

// Validación del controlador
if (!in_array($controllerName, $allowedControllers)) {
    die("Error: controlador no válido.");
}

// Verificar existencia del archivo antes de incluirlo
$controllerFile = "controllers/" . $controllerName . ".php";
if (!file_exists($controllerFile)) {
    die("Error: archivo del controlador no encontrado.");
}

require_once $controllerFile;

// Crear instancia del controlador
$controller = new $controllerName();

// Verificar si el método existe en el controlador
if (!method_exists($controller, $method)) {
    die("Error: método '$method' no encontrado en el controlador '$controllerName'.");
}

// Ejecutar el método
call_user_func([$controller, $method]);
