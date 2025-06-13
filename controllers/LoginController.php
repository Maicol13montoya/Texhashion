<?php
require_once 'models/Login.php';

/**
 * Clase Controlador Login
 */
class LoginController
{
    // Atributo para conectar al modelo
    private $model;

    // Constructor
    public function __construct()
    {
        $this->model = new Login;
    }

    // Método para mostrar la vista de login o redirigir si ya hay sesión activa
    public function index()
    {
        if (isset($_SESSION['user'])) {
            header('Location: ?controller=home');
            exit();
        } else {
            require_once 'views/login.php';
        }
    }

    // Función que permite iniciar sesión
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['contrasena'])) {
            $email = trim($_POST['email']);
            $contrasena = trim($_POST['contrasena']);

            // Validar usuario a través del modelo
            $usuario = $this->model->validateUser($email, $contrasena);

            if (is_array($usuario) && isset($usuario['id']) && $usuario['id'] > 0) {
                $_SESSION['user'] = $email;
                $_SESSION['user_role'] = $usuario['rol'];

                header('Location: ?controller=home');
                exit();
            } else {
                // Credenciales inválidas
                $error = [
                    'errorMessage' => 'Correo o contraseña incorrectos.',
                    'email' => $email
                ];
                require_once 'views/login.php';
            }
        } else {
            // Datos no enviados correctamente
            $error = [
                'errorMessage' => 'Por favor ingresa tu correo y contraseña.'
            ];
            require_once 'views/login.php';
        }
    }

    // Método para cerrar sesión
    public function logout()
    {
        if (isset($_SESSION['user'])) {
            session_destroy();
        }
        header('Location: ?controller=login');
        exit();
    }
}
