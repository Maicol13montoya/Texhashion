<?php

class Factura
{
    private $idFacturas;
    private $Cantidad;
    private $informacion_del_producto;
    private $Fecha_de_Emision;
    private $Precio_Total;
    private $Numero_Factura;
    private $idCliente ;
    private $Direccion_Facturacion;
    private $Estado_Factura ;
    private $Fecha_Pago;
    private $Referencia_Pago;
    private $status;
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new Database();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Obtener todas las facturas
    public function getAll()
    {
        try {
            $strSql = "SELECT f.*,e.Estados AS EstadoNombre,u.nombre, u.apellido, pt.Nombre_Producto
                       FROM facturas f 
                       JOIN estados e ON f.Estado_Factura = e.idEstados 
                       JOIN usuario u ON f.idCliente = u.id
                       JOIN productos_terminados pt ON f.Informacion_del_Producto = pt.idProductos WHERE f.status = 'IN'";
            return $this->pdo->select($strSql);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Crear nueva factura
    public function newFactura($data)
    {
        try {
            $this->pdo->insert('facturas', $data);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // Obtener factura por ID
    public function getFacturasId($idFacturas)
    {
        try {
            $strSql = "SELECT f.*, 
                              e.Estados AS EstadoNombre, 
                              u.nombre, 
                              u.apellido 
                       FROM facturas f 
                       JOIN estados e ON f.Estado_Factura = e.idEstados 
                       JOIN usuario u ON f.idCliente = u.id WHERE f.idFacturas = :idFacturas ";
            $params = ['idFacturas' => $idFacturas];
            return $this->pdo->select($strSql, $params);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Editar factura
    public function editFactura($data)
    {
        try {
            $strWhere = 'idFacturas	 = ' . $data['idFacturas'];
            $this->pdo->update('Facturas', $data, $strWhere);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Eliminar factura (cambia el estado a inactivo)
    public function deleteFacturas($idFacturas)
    {
        try {
            // Cambia la consulta para que se ajuste al método que estás usando
            $strWhere = 'idFacturas = :idFacturas';
            $data = ['status' => 'OUT', 'idFacturas' => $idFacturas];

            // Asegúrate de que tu método update esté manejando los parámetros correctamente
            $this->pdo->update('Facturas', $data, $strWhere);

            return true; // Indica que la operación fue exitosa
        } catch (PDOException $e) {
            return $e->getMessage(); // Devuelve el mensaje de error
        }
    }

    // Obtener todos los estados

    public function getEstados($Estado)
    {
        try {
            $strSql = "SELECT idEstados, Estados FROM estados";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getProductosT()
    {
        try {
            $strSql = "SELECT * FROM productos_terminados";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    // Obtener todos los clientes
    public function getUsuariosPTAll()
    {
        try {
            $strSql = "SELECT id, CONCAT(nombre, ' ', apellido) AS NombreCompleto FROM usuario WHERE rol = 4";
            return $this->pdo->select($strSql);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
