<?php
require_once 'models/Materia_prima.php';
require_once 'models/Usuario.php';
require_once 'models/Categoria.php';
require_once 'models/Estado.php';
require_once 'models/Unidad_medida.php';

class MateriaPrimaController
{
    private $model;
    private $usuarios;
    private $categorias;
    private $estados;
    private $unidad_medidas;

    public function __construct()
    {
        try {
            $this->model = new MateriaPrima;
            $this->categorias = new Categoria;
            $this->estados = new Estado;
            $this->unidad_medidas = new UnidadMedida;
            $this->usuarios = new Usuarios;

            if (!isset($_SESSION['user'])) {
                header('Location: ?controller=login');
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function index()
    {
        if (isset($_SESSION['user'])) {
            $materiaPrimaList = $this->model->getAll();
            $arrCategoria = [];
            $arrEstado = [];
            $arrUniMed = [];
            $arrProveedores = [];

            foreach ($materiaPrimaList as $materiaPrima) {
                array_push($arrCategoria, $this->model->getCategorias($materiaPrima['idProducto']));
                array_push($arrEstado, $this->model->getEstados($materiaPrima['idProducto']));
                array_push($arrUniMed, $this->model->getUnidadMedida($materiaPrima['idProducto']));
                array_push($arrProveedores, $this->model->getProveedores($materiaPrima['idProducto']));
            }

            ob_start();
            require_once 'views/Materia_prima/list.php';
            $content = ob_get_clean();
            require_once 'views/home.php';
        } else {
            require_once 'views/login.php';
        }
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->newMateriaPrima(
                $_POST['Nombre'],
                $_POST['Descripcion'],
                $_POST['Fecha_Ingreso'],
                $_POST['Precio_Unidad'],
                $_POST['Cantidad_Stock'],
                $_POST['id_Proveedor'],
                $_POST['Categoria'],
                $_POST['Unidad_Medida'],
                $_POST['Estado']
            );
            header('Location: ?controller=MateriaPrima&method=index');
            exit();
        }

        $categorias = $this->categorias->getAll();
        $estados = $this->estados->getAll();
        $unidad_medidas = $this->unidad_medidas->getAll();
        $usuarios = $this->usuarios->getAll();

        ob_start();
        require_once 'views/Materia_prima/new.php';
        $content = ob_get_clean();
        require_once 'views/home.php';
    }

    public function save()
    {
        $data = [
            'Nombre' => $_POST['Nombre'],
            'Descripcion' => $_POST['Descripcion'],
            'Fecha_Ingreso' => $_POST['Fecha_Ingreso'],
            'Precio_Unidad' => $_POST['Precio_Unidad'],
            'Cantidad_Stock' => $_POST['Cantidad_Stock'],
            'id_Proveedor' => $_POST['id_Proveedor'],
            'Categoria' => $_POST['Categoria'],
            'Unidad_Medida' => $_POST['Unidad_Medida'],
            'Fecha_Actualizacion' => $_POST['Fecha_Actualizacion'],
            'Estado' => $_POST['Estado'],
            'status' => 'IN'
        ];

        $result = $this->model->newMateriaPrima($data);

        if ($result === true) {
            header('Location: ?controller=MateriaPrima&method=index');
            exit();
        } else {
            echo "Error al guardar el producto: " . $result;
        }
    }

    public function edit()
    {
        if (isset($_REQUEST['idProducto'])) {
            $idProducto = $_REQUEST['idProducto'];
            $data = $this->model->getMateriaPrimaId($idProducto);
            $estados = $this->model->getEstados($idProducto);
            $proveedores = $this->model->getProveedores($idProducto);
            $unidadMedidas = $this->model->getUnidadMedida($idProducto);
            $categorias = $this->model->getCategorias($idProducto);

            ob_start();
            require_once 'views/Materia_prima/edit.php';
            $content = ob_get_clean();
            require_once 'views/home.php';
        } else {
            echo "Error: 'idProducto' no está definido.";
        }
    }

    public function update()
    {
        if ($_POST) {
            $dataMateriaPrima = [
                'idProducto' => $_POST['idProducto'],
                'Nombre' => $_POST['Nombre'],
                'Descripcion' => $_POST['Descripcion'],
                'Fecha_Ingreso' => $_POST['Fecha_Ingreso'],
                'Precio_Unidad' => $_POST['Precio_Unidad'],
                'Cantidad_Stock' => $_POST['Cantidad_Stock'],
                'id_Proveedor' => $_POST['id_Proveedor'],
                'Categoria' => $_POST['Categoria'],
                'Unidad_Medida' => $_POST['Unidad_Medida'],
                'Fecha_Actualizacion' => $_POST['Fecha_Actualizacion'],
                'Estado' => $_POST['Estado']
            ];

            $this->model->editMateriaPrima($dataMateriaPrima);
            header('Location: ?controller=MateriaPrima&method=index');
            exit();
        }
    }

    public function deleteOut()
    {
        if (isset($_REQUEST['idProducto'])) {
            $idProducto = $_REQUEST['idProducto'];
            $result = $this->model->deleteMateriaPrima($idProducto);

            if ($result === true) {
                header('Location: ?controller=MateriaPrima&method=index');
                exit();
            } else {
                echo "Error al eliminar la materia prima: " . $result;
            }
        } else {
            echo "Error: 'idProducto' no está definido.";
        }
    }
}
