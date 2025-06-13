<?php
namespace Controladores;

use Modelos\Facturas;
use Modelos\Usuario;
use Modelos\Estado;
use Modelos\ProductosTerminados;

class FacturasController
{
    private $modelo;
    private $usuarios;
    private $estados;
    private $productosTerminados;

    public function __construct()
    {
        try {
            $this->modelo = new Facturas();
            $this->usuarios = new Usuario();
            $this->estados = new Estado();
            $this->productosTerminados = new ProductosTerminados();

            if (!isset($_SESSION['usuario'])) {
                header('Location: ?controller=login');
                exit;
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function index()
    {
        if (isset($_SESSION['usuario'])) {
            $facturas = $this->modelo->obtenerTodo();
            $arrEstado = [];
            $arrUsuario = [];
            $arrProductosTerminados = [];

            foreach ($facturas as $factura) {
                $estados = $this->modelo->obtenerEstados($factura->idFacturas);
                array_push($arrEstado, $estados);
            }

            foreach ($facturas as $factura) {
                $usuarios = $this->modelo->getUsuariosPTAll($factura->idFacturas);
                array_push($arrUsuario, $usuarios);
            }

            foreach ($facturas as $factura) {
                $productos = $this->modelo->obtenerProductosT($factura->idFacturas);
                array_push($arrProductosTerminados, $productos);
            }

            include_once 'vistas/Factura/lista.php';
            include_once 'vistas/inicio.php';
        } else {
            include_once 'vistas/login.php';
        }
    }

    public function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->nuevaFactura([
                'Cantidad' => $_POST['Cantidad'],
                'Informacion_Producto' => $_POST['Informacion_Producto'],
                'Fecha_Emision' => $_POST['Fecha_Emision'],
                'Precio_Total' => $_POST['Precio_Total'],
                'Numero_Factura' => $_POST['Numero_Factura'],
                'idCliente' => $_POST['idCliente'],
                'Direccion_Facturacion' => $_POST['Direccion_Facturacion'],
                'Estado_Factura' => $_POST['Estado_Factura'],
                'Fecha_Pago' => $_POST['Fecha_Pago'],
                'Referencia_Pago' => $_POST['Referencia_Pago'],
            ]);
            header('Location: ?controller=Facturas&method=index');
            exit;
        }

        include_once 'vistas/Factura/nuevo.php';
        include_once 'vistas/inicio.php';
    }

    public function guardar()
    {
        $this->modelo->nuevaFactura([
            'idFacturas' => $_POST['idFacturas'],
            'Cantidad' => $_POST['Cantidad'],
            'Informacion_Producto' => $_POST['Informacion_Producto'],
            'Fecha_Emision' => $_POST['Fecha_Emision'],
            'Precio_Total' => $_POST['Precio_Total'],
            'Numero_Factura' => $_POST['Numero_Factura'],
            'idCliente' => $_POST['idCliente'],
            'Direccion_Facturacion' => $_POST['Direccion_Facturacion'],
            'Estado_Factura' => $_POST['Estado_Factura'],
            'Fecha_Pago' => $_POST['Fecha_Pago'],
            'Referencia_Pago' => $_POST['Referencia_Pago'],
        ]);

        header('Location: ?controller=Facturas&method=index');
        exit;
    }

    public function editar()
    {
        if (isset($_REQUEST['idFacturas'])) {
            $idFacturas = $_REQUEST['idFacturas'];
            // $datos = $this->modelo->getFacturasId($idFacturas); // Eliminado por no usarse
            include_once 'vistas/Factura/editar.php';
            include_once 'vistas/inicio.php';
        } else {
            echo "Error: 'idFacturas' no está definido.";
        }
    }

    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->editarFactura([
                'idFacturas' => $_POST['idFacturas'],
                'Cantidad' => $_POST['Cantidad'],
                'Informacion_Producto' => $_POST['Informacion_Producto'],
                'Fecha_Emision' => $_POST['Fecha_Emision'],
                'Precio_Total' => $_POST['Precio_Total'],
                'Numero_Factura' => $_POST['Numero_Factura'],
                'idCliente' => $_POST['idCliente'],
                'Direccion_Facturacion' => $_POST['Direccion_Facturacion'],
                'Estado_Factura' => $_POST['Estado_Factura'],
                'Fecha_Pago' => $_POST['Fecha_Pago'],
                'Referencia_Pago' => $_POST['Referencia_Pago'],
            ]);

            header('Location: ?controller=Facturas&method=index');
            exit;
        }
    }

    public function eliminarOut()
    {
        if (isset($_REQUEST['idFacturas'])) {
            $idFacturas = $_REQUEST['idFacturas'];
            $result = $this->modelo->eliminarFacturas($idFacturas);

            if ($result === true) {
                header('Location: ?controller=Facturas&method=index');
                exit;
            } else {
                echo "Error al eliminar la factura: " . $result;
            }
        } else {
            echo "Error: 'idFacturas' no está definido.";
        }
    }
}
