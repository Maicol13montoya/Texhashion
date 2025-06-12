<?php
session_start();
require_once 'providers/Database.php';

// Lista blanca de controladores permitidos
$allowedControllers = [
    'CorreoController',
    'FacturasController',
    'HomeController',
    'IndexController',
    'LoginController',
    'MateriaPriemaController', // Corrige si es necesario
    'OrdenesController',
    'ProductosTerminadosController',
    'UsuariosController'
];

$defaultController = 'IndexController';
$defaultMethod = 'index';

// Obtener controlador y método desde la URL
$controllerName = isset($_REQUEST['controller']) ? ucfirst($_REQUEST['controller']) . 'Controller' : $defaultController;
$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : $defaultMethod;

// Validación segura del controlador
if (!in_array($controllerName, $allowedControllers)) {
    die("Error: controlador no válido.");
}

// Verificar existencia del archivo antes de incluirlo
$controllerFile = "controllers/" . $controllerName . ".php";
if (!file_exists($controllerFile)) {
    die("Error: archivo de controlador no encontrado.");
}

require_once $controllerFile;

// Instanciar controlador y llamar al método
$controller = new $controllerName();

if (!method_exists($controller, $method)) {
    die("Error: método '$method' no encontrado en '$controllerName'.");
}

call_user_func([$controller, $method]);
?>
