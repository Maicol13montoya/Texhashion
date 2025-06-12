<?php
class Orden
{
    private $idOrden;
    private $idCliente;
    private $Fecha_Orden;
    private $Total_Total;
    private $Cantidad_Producto;
    private $Fecha_Entrega;
    private $idProductosTerminados;
    private $idMateriaPrima;
    private $Estado;
    private $status;
    private $pdo;

    // Constructor con visibilidad explícita
    public function __construct()
    {
        try {
            $this->pdo = new Database;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $strSql = "SELECT * FROM orden o 
                       JOIN estados e ON o.Estado = e.idEstados
                       JOIN productos_terminados pt ON o.idProductosTerminados = pt.idProductos
                       JOIN materia_prima mp ON o.idMateriaPrima = mp.idProducto
                       JOIN usuario u ON o.idCliente = u.id  
                       WHERE o.status = 'IN'";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function newOrdenes($data)
    {
        try {
            $this->pdo->insert('orden', $data);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getOrdenById($idOrden)
    {
        try {
            $strSql = "SELECT o.*, 
                              e.Estados AS EstadoNombre, 
                              pt.Nombre_Producto AS ProductoTerminadoNombre, 
                              mp.Nombre AS MateriaPrimaNombre, 
                              c.nombre AS ClienteNombre, 
                              c.apellido AS ClienteApellido
                       FROM orden o 
                       JOIN estados e ON o.Estado = e.idEstados 
                       JOIN productos_terminados pt ON o.idProductosTerminados = pt.idProductos
                       JOIN materia_prima mp ON o.idMateriaPrima = mp.idProducto
                       JOIN usuario c ON o.idCliente = c.id
                       WHERE o.idOrden = :idOrden";
            $arrayData = ['idOrden' => $idOrden];
            $query = $this->pdo->select($strSql, $arrayData);
            return $query;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function editOrdenes($data)
    {
        try {
            $strWhere = 'idOrden = ' . $data['idOrden'];
            $this->pdo->update('orden', $data, $strWhere);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteOrdenes($idOrden)
    {
        try {
            $strWhere = 'idOrden = :idOrden';
            $data = ['status' => 'OUT', 'idOrden' => $idOrden];
            $this->pdo->update('orden', $data, $strWhere);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getRol()
    {
        try {
            $strSql = "SELECT idRol, rol FROM rol WHERE idRol = 4";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getProductosTerminados()
    {
        try {
            $strSql = "SELECT idProductos, Nombre_Producto FROM productos_terminados";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getMateriasPrimas()
    {
        try {
            $strSql = "SELECT idProducto AS idMateriaPrima, Nombre AS NombreMateriaPrima FROM materia_prima";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getEstados()
    {
        try {
            $strSql = "SELECT idEstados, Estados FROM estados";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
