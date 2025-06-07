<?php


require 'models/Ordenes.php';
require 'models/Usuario.php';
require 'models/Materia_prima.php';
require 'models/Estado.php';
require 'models/ProductosTerminados.php';

class OrdenesController
{
    private $model;
    private $usuarios;
    private $productosTerminados;
    private $materiasPrimas;
    private $estados;

    public function __construct()
    {
        try {
            $this->model = new Orden;
            $this->materiasPrimas = new MateriaPrima;
            $this->estados = new Estado;
            $this->usuarios = new Usuarios;
            $this->productosTerminados = new ProductosTerminados;

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
            $OrdenesController = $this->model->getAll();

            $arrmateriasprimas = [];
            $arrEstado = [];
            $arrusuarios = [];
            $arrProductosTerminados = [];
            $arrNotificaciones = [];

            $fechaActual = new DateTime();
            $diasAnticipacion = 3;
            $fechaLimite = (new DateTime())->modify("+$diasAnticipacion days");

            foreach ($OrdenesController as $Ordenes) {
                $materiasprimas = $this->model->getMateriasPrimas($Ordenes['idOrden']);
                array_push($arrmateriasprimas, $materiasprimas);

                $estados = $this->model->getEstados($Ordenes['idOrden']);
                array_push($arrEstado, $estados);

                $usuarios = $this->model->getRol($Ordenes['idOrden']);
                array_push($arrusuarios, $usuarios);

                $ProductosTerminados = $this->model->getProductosTerminados($Ordenes['idOrden']);
                array_push($arrProductosTerminados, $ProductosTerminados);

                $fechaEntrega = new DateTime($Ordenes['Fecha_Entrega']);
                if ($fechaEntrega <= $fechaLimite && $fechaEntrega >= $fechaActual) {
                    $estadoNombre = $Ordenes['Estados'] ?? 'Estado desconocido';
                    $clienteNombre = $Ordenes['nombre'] ?? 'Cliente desconocido';

                    array_push($arrNotificaciones, [
                        'idOrden' => $Ordenes['idOrden'],
                        'titulo' => 'Entrega próxima de Orden #' . $Ordenes['idOrden'],
                        'fecha' => $Ordenes['Fecha_Entrega'],
                        'mensaje' => 'La orden está por entregarse el ' . $Ordenes['Fecha_Entrega'] .
                            '. Cliente: ' . $clienteNombre .
                            '. Estado: ' . $estadoNombre .
                            '. Total: $' . number_format($Ordenes['Total_Total'], 2) .
                            '. Cantidad de Productos: ' . $Ordenes['Cantidad_Producto']
                    ]);
                }
            }

            ob_start();
            require 'views/Ordenes/list.php';
            $content = ob_get_clean();
            require 'views/home.php';
        } else {
            require 'views/login.php';
        }
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idCliente = $_POST['idCliente'];
            $fechaOrden = $_POST['Fecha_Orden'];
            $totalTotal = $_POST['Total_Total'];
            $cantidadProducto = $_POST['Cantidad_Producto'];
            $fechaEntrega = $_POST['Fecha_Entrega'];
            $idProductosTerminados = $_POST['idProductosTerminados'];
            $idMateriaPrima = $_POST['idMateriaPrima'];
            $estado = $_POST['Estado'];

            $this->model->newOrdenes([
                'idCliente' => $idCliente,
                'Fecha_Orden' => $fechaOrden,
                'Total_Total' => $totalTotal,
                'Cantidad_Producto' => $cantidadProducto,
                'Fecha_Entrega' => $fechaEntrega,
                'idProductosTerminados' => $idProductosTerminados,
                'idMateriaPrima' => $idMateriaPrima,
                'Estado' => $estado
            ]);

            header('Location: ?controller=Ordenes&method=index');
            exit();
        }

        $productosTerminados = $this->productosTerminados->getAll();
        $usuarios = $this->usuarios->getAll();
        $materiasPrimas = $this->materiasPrimas->getAll();
        $estados = $this->estados->getAll();
        $productosTerminados = $this->productosTerminados->getall();

        ob_start();
        require 'views/Ordenes/new.php';
        $content = ob_get_clean();
        require 'views/home.php';
    }

    public function save()
    {
        $data = [
            'idCliente' => $_POST['idCliente'],
            'Fecha_Orden' => $_POST['Fecha_Orden'],
            'Total_Total' => $_POST['Total_Total'],
            'Cantidad_Producto' => $_POST['Cantidad_Producto'],
            'Fecha_Entrega' => $_POST['Fecha_Entrega'],
            'idProductosTerminados' => $_POST['idProductosTerminados'],
            'idMateriaPrima' => $_POST['idMateriaPrima'],
            'Estado' => $_POST['estado']
        ];

        $this->model->newOrdenes($data);

        header('Location: ?controller=Ordenes&method=index');
    }

    public function edit()
    {
        if (isset($_REQUEST['idOrden'])) {
            $idOrden = $_REQUEST['idOrden'];
            $data = $this->model->getOrdenById($idOrden);

            $usuarios = $this->usuarios->getAll();
            $productosTerminados = $this->productosTerminados->getAll();
            $materiasPrimas = $this->materiasPrimas->getAll();
            $estados = $this->estados->getAll();
            $productosTerminados = $this->productosTerminados->getALL();

            ob_start();
            require 'views/Ordenes/edit.php';
            $content = ob_get_clean();
            require 'views/home.php';
        } else {
            echo "Error: 'idOrden' no está definido.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dataOrden = [
                'idOrden' => $_POST['idOrden'],
                'idCliente' => $_POST['idCliente'],
                'Fecha_Orden' => $_POST['Fecha_Orden'],
                'Total_Total' => $_POST['Total_Total'],
                'Cantidad_Producto' => $_POST['Cantidad_Producto'],
                'Fecha_Entrega' => $_POST['Fecha_Entrega'],
                'idProductosTerminados' => $_POST['idProductosTerminados'],
                'idMateriaPrima' => $_POST['idMateriaPrima'],
                'Estado' => $_POST['estado']
            ];

            $resOrden = $this->model->editOrdenes($dataOrden);

            header('Location: ?controller=Ordenes&method=index');
        }
    }

    public function delete()
    {
        if (isset($_REQUEST['idOrden'])) {
            $idOrden = $_REQUEST['idOrden'];

            $result = $this->model->deleteOrdenes($idOrden);

            if ($result === true) {
                header('Location: ?controller=Ordenes&method=index');
                exit();
            } else {
                echo "Error al eliminar la Ordenes: " . $result;
            }
        } else {
            echo "Error: 'idOrden' no está definido.";
        }
    }
}