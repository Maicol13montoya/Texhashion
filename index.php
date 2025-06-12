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

// Obtener controlador desde la URL o usar el predeterminado
$controllerParam = isset($_REQUEST['controller']) ? $_REQUEST['controller'] : '';
$controllerName = ucfirst($controllerParam) . 'Controller';
$controllerName = in_array($controllerName, $allowedControllers) ? $controllerName : $defaultController;

// Obtener método desde la URL o usar el predeterminado
$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : $defaultMethod;

// Verificar si el archivo del controlador existe
$controllerFile = "controllers/" . $controllerName . ".php";
if (!file_exists($controllerFile)) {
    die("Error: archivo del controlador no encontrado.");
}
require_once $controllerFile;

// Crear instancia del controlador
$controller = new $controllerName();

// Verificar si el método existe en el controlador
if (!method_exists($controller, $method)) {
    die("Error: método no válido en el controlador.");
}

// Ejecutar el método de forma segura
call_user_func([$controller, $method]);
