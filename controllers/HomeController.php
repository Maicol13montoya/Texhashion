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
    // Cargar la vista de inicio
    try {
        require_once 'vistas/inicio.php';
    } catch (\Exception $e) {
        error_log("Error al cargar la vista: " . $e->getMessage()); // Registrar error en el log del servidor
        echo "Error al cargar la vista."; // Mensaje simple para el usuario
    }
}
