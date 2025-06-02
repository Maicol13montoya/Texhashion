<?php
require 'models/Materia_prima.php';
require 'models/Usuario.php';
require 'models/Categoria.php';
require 'models/Estado.php';
require 'models/Unidada_medida.php';

class MateriaPriemaController
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
            $this->unidad_medidas = new UnidadaMedida;
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
            $MateriaPriemaController = $this->model->getAll();
            $arrCategoria = [];
            $arrEstado = [];
            $arrUniMed = [];
            foreach ($MateriaPriemaController as $MateriaPrima) {
                $categorias = $this->model->getCategorias($MateriaPrima->idProducto);
                array_push($arrCategoria, $categorias);
            }
            foreach ($MateriaPriemaController as $MateriaPrima) {
                $estados = $this->model->getEstados($MateriaPrima->idProducto);
                array_push($arrEstado, $estados);
            }
            foreach ($MateriaPriemaController as $MateriaPrima) {
                $unidad_medidas = $this->model->getUnidadMedida($MateriaPrima->idProducto);
                array_push($arrUniMed, $unidad_medidas);
            }
            foreach ($MateriaPriemaController as $MateriaPrima) {
                $usuarios = $this->model->getProveedores($MateriaPrima->idProducto);
                array_push($arrUniMed, $usuarios);
            }
            ob_start();
            require 'views/Materia_prima/list.php';
            $content = ob_get_clean();
            require 'views/home.php';
        } else {
            require 'views/login.php';
        }
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validar y procesar los datos enviados por POST
            $nombre = $_POST['Nombre'];
            $descripcion = $_POST['Descripcion'];
            $fechaIngreso = $_POST['Fecha_Ingreso'];
            $precioUnidad = $_POST['Precio_Unidad'];
            $cantidadStock = $_POST['Cantidad_Stock'];
            $proveedor = $_POST['id_Proveedor'];
            $categoria = $_POST['Categoria'];
            $unidadMedida = $_POST['Unidad_Medida'];
            $estado = $_POST['Estado'];

            // Llamar al modelo para agregar el nuevo producto
            $this->model->newMateriaPrima(
                $nombre,
                $descripcion,
                $fechaIngreso,
                $precioUnidad,
                $cantidadStock,
                $proveedor,
                $categoria,
                $unidadMedida,
                $estado
            );

            // Redirigir después de agregar el producto
            header('Location: ?controller=MateriaPriema&method=index');
            exit();
        }

        // Obtener categorías y proveedores
        $categorias = $this->categorias->getAll();
        $estados = $this->estados->getAll();
        $unidad_medidas = $this->unidad_medidas->getAll();
        $usuarios = $this->usuarios->getAll();
        // $proveedores = (new Usuario())->getAll(); // Asumiendo que `Usuario` es el modelo correcto para proveedores

        // Si es GET, mostrar el formulario de creación
        ob_start();
        require 'views/Materia_prima/new.php'; // La vista del formulario de creación
        $content = ob_get_clean();
        require 'views/home.php';
    }

    public function save()
    {
        // Filtrar los datos que vienen del formulario
        $data = [
            'Nombre' => $_POST['Nombre'],
            'Descripcion' => $_POST['Descripcion'],
            'Fecha_Ingreso' => $_POST['Fecha_Ingreso'],
            'Precio_Unidad' => $_POST['Precio_Unidad'],
            'Cantidad_Stock' => $_POST['Cantidad_Stock'],
            'id_Proveedor' => $_POST['id_Proveedor'],
            'Categoria' => $_POST['estado'],
            'Unidad_Medida' => $_POST['Unidad_Medida'],
            'Fecha_Actualizacion' => $_POST['Fecha_Actualizacion'],
            'Estado' => $_POST['estado']
        ];

        // Llamar al modelo para realizar la inserción
        $this->model->newMateriaPrima($data);

        // Redirigir después de guardar
        header('Location: ?controller=MateriaPriema&method=index');
    }

    public function edit()
    {
        if (isset($_REQUEST['idProducto'])) {
            $idProducto = $_REQUEST['idProducto'];
            $data = $this->model->getMateriaPrimaId($idProducto);
            // Verificar si $data no está vacío
            $estados = $this->model->getEstados($idProducto);
            $proveedores = $this->model->getProveedores($idProducto);
            $unidadMedidas = $this->model->getUnidadMedida($idProducto);
            $categorias = $this->model->getCategorias($idProducto);

            ob_start();
            require 'views/Materia_prima/edit.php';
            $content = ob_get_clean();
            require 'views/home.php';
        } else {
            echo "Error: 'idProducto' no está definido.";
        }
    }


    public function update()
    {
        if (isset($_POST)) {
            // Organiza array para la tabla movie
            $dataMateriaPrima = [
                'idProducto' => $_POST['idProducto'],
                'Nombre' => $_POST['Nombre'],
                'Descripcion' => $_POST['Descripcion'],
                'Fecha_Ingreso' => $_POST['Fecha_Ingreso'],
                'Precio_Unidad' => $_POST['Precio_Unidad'],
                'Cantidad_Stock' => $_POST['Cantidad_Stock'],
                'id_Proveedor' => $_POST['id_Proveedor'],
                'categoria' => $_POST['categoria'],
                'Unidad_Medida' => $_POST['Unidad_Medida'],
                'Fecha_Actualizacion' => $_POST['Fecha_Actualizacion'],
                'estado' => $_POST['estado']
            ];
            $respMovie = $this->model->editMateriaPrima($dataMateriaPrima);

            // Redirigir después de guardar
            header('Location: ?controller=MateriaPriema&method=index');
        }
    }

    public function deleteOut()
    {
        // Verifica que se ha recibido el idProducto
        if (isset($_REQUEST['idProducto'])) {
            $idProducto = $_REQUEST['idProducto'];

            // Llama al método del modelo para eliminar la materia prima
            $result = $this->model->deleteMateriaPrima($idProducto);

            // Maneja el resultado
            if ($result === true) {
                // Redirigir después de marcar como "OUT"
                header('Location: ?controller=MateriaPriema&method=index');
                exit();
            } else {
                // Si hay un error, podrías manejarlo aquí (ej. mostrar un mensaje de error)
                echo "Error al eliminar la materia prima: " . $result;
            }
        } else {
            echo "Error: 'idProducto' no está definido.";
        }
    }
}
