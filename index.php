<?php
session_start();
require_once 'providers/Database.php';

$defaultController = 'IndexController';
$defaultMethod = 'index';

// Lista blanca de rutas válidas (controlador => métodos permitidos)
$allowedRoutes = [
    'index' => ['controller' => 'IndexController', 'methods' => ['index']],
    'login' => ['controller' => 'LoginController', 'methods' => ['index', 'validar', 'logout']],
    'facturas' => ['controller' => 'FacturasController', 'methods' => ['index', 'ver']],
    'usuarios' => ['controller' => 'UsuariosController', 'methods' => ['index', 'crear', 'editar']],
    'materiaprima' => ['controller' => 'MateriaprimaController', 'methods' => ['index', 'agregar']],
    'ordenes' => ['controller' => 'OrdenesController', 'methods' => ['index', 'generar']],
    'producto' => ['controller' => 'ProductosTerminadosController', 'methods' => ['index', 'detalle']],
    'correo' => ['controller' => 'CorreoController', 'methods' => ['enviar']],
    'home' => ['controller' => 'HomeController', 'methods' => ['index']]
];

// Obtener parámetros
$controllerKey = strtolower($_REQUEST['controller'] ?? 'index');
$method = $_REQUEST['method'] ?? 'index';

// Verificar si el controlador está permitido
if (!array_key_exists($controllerKey, $allowedRoutes)) {
    die("Error: controlador no permitido.");
}

$route = $allowedRoutes[$controllerKey];
$controllerName = $route['controller'];

// Verificar si el método está permitido para ese controlador
if (!in_array($method, $route['methods'])) {
    die("Error: método no permitido para este controlador.");
}

// Verificar si el archivo existe
$controllerFile = "controllers/" . $controllerName . ".php";
if (!file_exists($controllerFile)) {
    die("Error: archivo del controlador no encontrado.");
}
require_once $controllerFile;

// Instanciar el controlador y llamar al método
$controller = new $controllerName();
if (!method_exists($controller, $method)) {
    die("Error: método no válido en el controlador.");
}
call_user_func([$controller, $method]);
