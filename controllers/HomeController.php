<?php

/**
 * Clase HomeController para cargar el home del proyecto
 */
class HomeController
{
    public function __construct()
    {
        // Verifica si la sesión está activa
        if (!isset($_SESSION['user'])) {
            error_log("Acceso denegado. La sesión no está activa."); // Registro de error
            header('Location: ?controller=login');
            exit(); // Asegúrate de terminar el script aquí
        }
    }

    public function index()
    {
        // Cargar la vista del home
        try {
            require_once 'vistas/inicio.php';
        } catch (Exception $e) {
            error_log("Error al cargar vistas: " . $e->getMessage()); // Registro de error
            echo "Error al cargar la vista."; // Mensaje de error simple
        }
    }
}
