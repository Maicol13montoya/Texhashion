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

            // Obtener todas las órdenes
            $OrdenesController = $this->model->getAll();

            // Inicializar arrays de datos
            $arrmateriasprimas = [];
            $arrEstado = [];
            $arrusuarios = [];
            $arrProductosTerminados = [];
            $arrNotificaciones = [];  // Aquí almacenaremos las notificaciones

            // Obtener la fecha actual y la fecha límite para las notificaciones
            $fechaActual = new DateTime();
            $diasAnticipacion = 3;  // Número de días antes de la entrega que queremos notificar
            $fechaLimite = (new DateTime())->modify("+$diasAnticipacion days");

            // Recorrer todas las órdenes para obtener los detalles y las notificaciones
            foreach ($OrdenesController as $Ordenes) {
                // Obtener los detalles de cada orden (materias primas, estados, etc.)
                $materiasprimas = $this->model->getMateriasPrimas($Ordenes->idOrden);
                array_push($arrmateriasprimas, $materiasprimas);

                $estados = $this->model->getEstados($Ordenes->idOrden);
                array_push($arrEstado, $estados);

                $usuarios = $this->model->getRol($Ordenes->idOrden);
                array_push($arrusuarios, $usuarios);

                $ProductosTerminados = $this->model->getProductosTerminados($Ordenes->idOrden);
                array_push($arrProductosTerminados, $ProductosTerminados);

                // Verificar si la fecha de entrega está dentro de los próximos días
                $fechaEntrega = new DateTime($Ordenes->Fecha_Entrega);
                if ($fechaEntrega <= $fechaLimite && $fechaEntrega >= $fechaActual) {
                    // Acceder a las propiedades del objeto correctamente
                    $estadoNombre = isset($Ordenes->EstadoNombre) ? $Ordenes->EstadoNombre : 'Estado desconocido';
                    $clienteNombre = isset($Ordenes->ClienteNombre) ? $Ordenes->ClienteNombre : 'Cliente desconocido';

                    array_push($arrNotificaciones, [
                        'idOrden' => $Ordenes->idOrden,
                        'titulo' => 'Entrega próxima de Orden #' . $Ordenes->idOrden,
                        'fecha' => $Ordenes->Fecha_Entrega,
                        'mensaje' => 'La orden está por entregarse el ' . $Ordenes->Fecha_Entrega .
                            '. Cliente: ' . $clienteNombre .
                            '. Estado: ' . $estadoNombre .
                            '. Total: $' . number_format($Ordenes->Total_Total, 2) .
                            '. Cantidad de Productos: ' . $Ordenes->Cantidad_Producto
                    ]);
                }
            }

            // Cargar la vista con las notificaciones
            ob_start();
            require 'views/Ordenes/list.php';  // Mostrar la vista con el calendario
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
            $idCliente = $_POST['idCliente'];
            $fechaOrden = $_POST['Fecha_Orden'];
            $totalTotal = $_POST['Total_Total'];
            $cantidadProducto = $_POST['Cantidad_Producto'];
            $fechaEntrega = $_POST['Fecha_Entrega'];
            $idProductosTerminados = $_POST['idProductosTerminados'];
            $idMateriaPrima = $_POST['idMateriaPrima'];
            $estado = $_POST['Estado'];

            // Llamar al modelo para agregar la nueva Ordenes
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

            // Redirigir después de agregar la Ordenes
            header('Location: ?controller=Ordenes&method=index');
            exit();
        }

        // Obtener clientes, productos terminados, materias primas y estados

        $productosTerminados = $this->productosTerminados->getAll();
        $usuarios = $this->usuarios->getAll();
        $materiasPrimas = $this->materiasPrimas->getAll();
        $estados = $this->estados->getAll();
        $productosTerminados = $this->productosTerminados->getall();


        // Si es GET, mostrar el formulario de creación
        ob_start();
        require 'views/Ordenes/new.php';
        $content = ob_get_clean();
        require 'views/home.php';
    }

    public function save()
    {
        // Filtrar los datos que vienen del formulario
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

        // Llamar al modelo para realizar la inserción
        $this->model->newOrdenes($data);

        // Redirigir después de guardar
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
            // Organiza array para actualizar la Ordenes
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

            // Redirigir después de actualizar
            header('Location: ?controller=Ordenes&method=index');
        }
    }

    public function delete()
    {
        // Verifica que se ha recibido el idOrden
        if (isset($_REQUEST['idOrden'])) {
            $idOrden = $_REQUEST['idOrden'];

            // Llama al método del modelo para eliminar la Ordenes
            $result = $this->model->deleteOrdenes($idOrden);

            // Maneja el resultado
            if ($result === true) {
                // Redirigir después de marcar como "OUT"
                header('Location: ?controller=Ordenes&method=index');
                exit();
            } else {
                // Si hay un error, podrías manejarlo aquí
                echo "Error al eliminar la Ordenes: " . $result;
            }
        } else {
            echo "Error: 'idOrden' no está definido.";
        }
    }
}
