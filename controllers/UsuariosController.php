<?php
require 'models/Usuario.php';
require 'models/Tipo_documento.php';
require 'models/Rol.php';
require_once 'utils/helpers.php';

class UsuariosController
{
    private $model;
    private $tipos_doc;
    private $roles;

    public function __construct()
    {
        try {
            $this->model = new Usuarios;
            $this->tipos_doc = new TipoDocumento;
            $this->roles = new Rol;
            if (!isset($_SESSION['user'])) {
                header('Location: ?controller=login');
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function index()
    {
        $UsuariosController = $this->model->getAll();
        ob_start();
        require 'views/Usuarios/list.php';
        $content = ob_get_clean();
        require 'views/home.php';
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => $_POST['nombre'],
                'apellido' => $_POST['apellido'],
                'correo_electronico' => $_POST['correo'],
                'tipo_documento' => $_POST['tipo_doc'],
                'documento' => $_POST['documento'],
                'direccion' => $_POST['direccion'],
                'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                'telefono' => $_POST['telefono'],
                'rol' => $_POST['rol'],
                'contrasena' => md5($_POST['contrasena']) // ejemplo de encriptación
            ];
            header('Location: ?controller=Usuarios&method=index');
            exit();
        }

        $tipos_doc = $this->tipos_doc->getAll();
        $roles = $this->roles->getAll();

        ob_start();
        require 'views/Usuarios/new.php';
        $content = ob_get_clean();
        require 'views/home.php';
    }

    public function save()
    {
        // Generar contraseña aleatoria
        $contrasena = generarContrasena();

        $data = [
            'nombre' => $_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'correo_electronico' => $_POST['correo'],
            'tipo_documento' => $_POST['tipo_doc'],
            'documento' => $_POST['documento'],
            'direccion' => $_POST['direccion'],
            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
            'telefono' => $_POST['telefono'],
            'rol' => $_POST['rol'],
            'contrasena' => md5($contrasena)
        ];

        $this->model->newUsuarios($data);

        require_once 'controllers/CorreoController.php';
        $correoController = new CorreoController();
        $correoController->enviarBienvenida($data['correo_electronico'], $data['nombre'], $contrasena);

        header('Location: ?controller=Usuarios&method=index');
    }


    public function edit()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $this->model->getUsuariosId($id);
            $tipos_doc = $this->tipos_doc->getAll();
            $roles = $this->roles->getAll();

            ob_start();
            require 'views/Usuarios/edit.php';
            $content = ob_get_clean();
            require 'views/home.php';
        } else {
            echo "Error: No se recibió el ID del usuario.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $_POST['id'],
                'nombre' => $_POST['nombre'],
                'apellido' => $_POST['apellido'],
                'correo_electronico' => $_POST['correo'],
                'tipo_documento' => $_POST['tipo_doc'],
                'documento' => $_POST['documento'],
                'direccion' => $_POST['direccion'],
                'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                'telefono' => $_POST['telefono'],
                'rol' => $_POST['rol']
            ];

            $this->model->editUsuarios($data);
            header('Location: ?controller=Usuarios&method=index');
            exit();
        }
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $this->model->deleteUsuarios($_GET['id']);
            header('Location: ?controller=Usuarios&method=index');
            exit();
        } else {
            echo "ID de usuario no recibido para eliminación.";
        }
    }
}
