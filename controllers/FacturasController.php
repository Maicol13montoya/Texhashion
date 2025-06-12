<?php
require_once 'models/Facturas.php';
require_once 'models/Usuario.php';
require_once 'models/Estado.php';
require_once 'models/ProductosTerminados.php';

class FacturasController
{
    private $model;
    private $usuarios;
    private $estados;
    private $productosTerminados;

    public function __construct()
    {
        try {
            $this->model = new Factura();
            $this->usuarios = new Usuarios();
            $this->estados = new Estado();
            $this->productosTerminados = new ProductosTerminados();
            if (!isset($_SESSION['user'])) {
                header('Location: ?controller=login');
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function index()
    {
        if (isset($_SESSION['user'])) {
            $FacturasController = $this->model->getAll();
            $arrEstado = [];
            $arrusuario = [];
            $arrProductosTerminado = [];

            foreach ($FacturasController as $Factura) {
                $estados = $this->model->getEstados($Factura->idFacturas);
                array_push($arrEstado, $estados);
            }

            foreach ($FacturasController as $Factura) {
                $usuarios = $this->model->getUsuariosPTAll($Factura->idFacturas);
                array_push($arrusuario, $usuarios);
            }

            foreach ($FacturasController as $Factura) {
                $ProductoTerminado = $this->model->getProductosT($Factura->idFacturas);
                array_push($arrProductosTerminado, $ProductoTerminado);
            }

            ob_start();
            require_once 'vistas/Factura/lista.php'; // Vista para listar facturas
            $contenido = ob_get_clean();
            require_once 'vistas/inicio.php';
        } else {
            require_once 'vistas/login.php';
        }
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $Cantidad = $_POST['Cantidad'];
            $Informacion_del_Producto = $_POST['Informacion_del_Producto'];
            $Fecha_de_Emision = $_POST['Fecha_de_Emision'];
            $Precio_Total = $_POST['Precio_Total'];
            $Numero_Factura = $_POST['Numero_Factura'];
            $idCliente = $_POST['idCliente'];
            $Direccion_Facturacion = $_POST['Direccion_Facturacion'];
            $Estado_Factura = $_POST['Estado_Factura'];
            $Fecha_Pago = $_POST['Fecha_Pago'];
            $Referencia_Pago = $_POST['Referencia_Pago'];

            $this->model->newFactura(
                $Cantidad,
                $Informacion_del_Producto,
                $Fecha_de_Emision,
                $Precio_Total,
                $Numero_Factura,
                $idCliente,
                $Direccion_Facturacion,
                $Estado_Factura,
                $Fecha_Pago,
                $Referencia_Pago
            );
            header('Location: ?controller=Facturas&method=index');
            exit();
        }

        $clientes = $this->model->getUsuariosPTAll();
        $estados = $this->estados->getAll();
        $productosTerminados = $this->productosTerminados->getAll();

        ob_start();
        require_once 'views/Factura/new.php'; // Vista para agregar factura
        $content = ob_get_clean();
        require_once 'views/home.php';
    }

    public function save()
    {
        $data = [
            'idFacturas' => $_POST['idFacturas'],
            'Cantidad' => $_POST['Cantidad'],
            'Informacion_del_Producto' => $_POST['Informacion_del_Producto'],
            'Fecha_de_Emision' => $_POST['Fecha_de_Emision'],
            'Precio_Total' => $_POST['Precio_Total'],
            'Numero_Factura' => $_POST['Numero_Factura'],
            'idCliente' => $_POST['idCliente'],
            'Direccion_Facturacion' => $_POST['Direccion_Facturacion'],
            'Estado_Factura' => $_POST['Estado_Factura'],
            'Fecha_Pago' => $_POST['Fecha_Pago'],
            'Referencia_Pago' => $_POST['Referencia_Pago'],
        ];
        $this->model->newFactura($data);
        header('Location: ?controller=Facturas&method=index');
    }

    public function edit()
    {
        if (isset($_REQUEST['idFacturas'])) {
            $idFacturas = $_REQUEST['idFacturas'];
            $data = $this->model->getFacturasId($idFacturas);
            $usuarios = $this->model->getUsuariosPTAll();
            $estados = $this->model->getEstados($idFacturas);
            $productosTerminados = $this->model->getProductosT($idFacturas);

            ob_start();
            require_once 'views/Factura/edit.php'; // Vista para editar factura
            $content = ob_get_clean();
            require_once 'views/home.php';
        } else {
            echo "Error: 'idFacturas' no está definido.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'idFacturas' => $_POST['idFacturas'],
                'Cantidad' => $_POST['Cantidad'],
                'Informacion_del_Producto' => $_POST['Informacion_del_Producto'],
                'Fecha_de_Emision' => $_POST['Fecha_de_Emision'],
                'Precio_Total' => $_POST['Precio_Total'],
                'Numero_Factura' => $_POST['Numero_Factura'],
                'idCliente' => $_POST['idCliente'],
                'Direccion_Facturacion' => $_POST['Direccion_Facturacion'],
                'Estado_Factura' => $_POST['Estado_Factura'],
                'Fecha_Pago' => $_POST['Fecha_Pago'],
                'Referencia_Pago' => $_POST['Referencia_Pago'],
            ];
            $this->model->editFactura($data);
            header('Location: ?controller=Facturas&method=index');
            exit();
        }
    }

    public function deleteOut()
    {
        if (isset($_REQUEST['idFacturas'])) {
            $idProducto = $_REQUEST['idFacturas'];
            $result = $this->model->deleteFacturas($idProducto);
            if ($result === true) {
                header('Location: ?controller=Facturas&method=index');
                exit();
            } else {
                echo "Error al eliminar la materia prima: " . $result;
            }
        } else {
            echo "Error: 'idProducto' no está definido.";
        }
    }
}
?>
