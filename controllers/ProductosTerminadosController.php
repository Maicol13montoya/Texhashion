<?php
require 'models/ProductoTerminado.php';
require 'models/Materia_prima.php';
require 'models/Estado.php';

class ProductosTerminadosController
{
    private $model;
    private $materiaPrima;
    private $estados;

    public function __construct()
    {
        try {
            $this->model = new ProductosTerminados;
            $this->materiaPrima = new MateriaPrima;
            $this->estados = new Estado;

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
            $productosTerminados = $this->model->getAll();
            $arrMateriaPrima = [];
            $arrEstado = [];

            foreach ($productosTerminados as $producto) {
                $materiaPrima = $this->model->getMateriasPrimas(); // Corregido: no debe pasar el idProducto
                array_push($arrMateriaPrima, $materiaPrima);

                $estado = $this->model->getEstados(); // Corregido: no debe pasar el idEstado
                array_push($arrEstado, $estado);
            }

            ob_start();
            require 'views/Produtos_Terminados/list.php';
            $content = ob_get_clean();
            require 'views/home.php';
        } else {
            require 'views/login.php';
        }
    }

    public function addProductoTerminado()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $Nombre_Producto = $_POST['Nombre_Producto'];
            $Cantidad_Disponible = $_POST['Cantidad_Disponible'];
            $DescripcionPT = $_POST['DescripcionPT'];
            $Fecha_Entrada = $_POST['Fecha_Entrada'];
            $Fecha_Salida = $_POST['Fecha_Salida'];
            $idmateria_prima = $_POST['idmateria_prima'];
            $Estado = $_POST['Estado'];

            // Pasar los datos como un array asociativo
            $data = [
                'Nombre_Producto' => $Nombre_Producto,
                'Cantidad_Disponible' => $Cantidad_Disponible,
                'DescripcionPT' => $DescripcionPT,
                'Fecha_Entrada' => $Fecha_Entrada,
                'Fecha_Salida' => $Fecha_Salida,
                'idmateria_prima' => $idmateria_prima,
                'idEstado' => $Estado
            ];

            // Llamar al modelo para agregar el nuevo producto
            $this->model->newProductoTerminado($data);

            header('Location: ?controller=ProductosTerminados&method=index');
            exit();
        }

        $materiaPrima = $this->materiaPrima->getAll();
        $estados = $this->estados->getAll();

        ob_start();
        require 'views/Produtos_Terminados/new.php';
        $content = ob_get_clean();
        require 'views/home.php';
    }

    public function saveProductoTerminado()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filtrar los datos que vienen del formulario
            $data = [
                'Nombre_Producto' => $_POST['Nombre_Producto'],
                'Cantidad_Disponible' => $_POST['Cantidad_Disponible'],
                'DescripcionPT' => $_POST['DescripcionPT'],
                'Fecha_Entrada' => $_POST['Fecha_Entrada'],
                'Fecha_Salida' => $_POST['Fecha_Salida'],
                'idmateria_prima' => $_POST['idmateria_prima'],
                'idEstado' => $_POST['idEstado']
            ];

            try {
                // Llamar al modelo para realizar la inserción
                $this->model->newProductoTerminado($data);
                header('Location: ?controller=ProductosTerminados&method=index');
                exit();
            } catch (PDOException $e) {
                echo "Error al guardar el producto: " . $e->getMessage();
            }
        }
    }

    public function edit()
    {
        if (isset($_REQUEST['idProductos'])) {
            $idProductos = $_REQUEST['idProductos'];
            $data = $this->model->getProductoTerminadoId($idProductos);

            $materiaPrima = $this->materiaPrima->getAll();
            $estados = $this->estados->getAll();

            ob_start();
            require 'views/Produtos_Terminados/edit.php';
            $content = ob_get_clean();
            require 'views/home.php';
        } else {
            echo "Error: 'idProductos' no está definido.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'idProductos' => $_POST['idProductos'],
                'Nombre_Producto' => $_POST['Nombre_Producto'],
                'Cantidad_Disponible' => $_POST['Cantidad_Disponible'],
                'DescripcionPT' => $_POST['DescripcionPT'],
                'Fecha_Entrada' => $_POST['Fecha_Entrada'],
                'Fecha_Salida' => $_POST['Fecha_Salida'],
                'idmateria_prima' => $_POST['idmateria_prima'],
                'idEstado' => $_POST['idEstado']
            ];

            $this->model->editProductoTerminado($data);
            header('Location: ?controller=ProductosTerminados&method=index');
            exit();
         
        }
    }

    public function deleteOut()
    {
        if (isset($_REQUEST['idProductos'])) {
            $idProductos = $_REQUEST['idProductos'];
            $result = $this->model->deleteProductoTerminado($idProductos);
            if ($result) {
                header('Location: ?controller=ProductosTerminados&method=index');
            } else {
                echo "Error al eliminar el producto.";
            }
        }
    }
}
