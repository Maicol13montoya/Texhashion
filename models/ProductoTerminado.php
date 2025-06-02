

<?php

class ProductosTerminados
{
    private $idProductos;
    private $Nombre_Producto;
    private $Cantidad_Disponible;
    private $Descripcion;
    private $Fecha_Entrada;
    private $Fecha_Salida;
    private $idmateria_prima;
    private $Estado;
    private $status;
    private $pdo;

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
            $strSql = "SELECT * FROM productos_terminados pt 
                        JOIN estados e ON pt.idEstado = e.idEstados 
                        JOIN materia_prima mp ON pt.idmateria_prima = mp.idProducto
                        WHERE pt.status = 'IN'";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

   
    public function newProductoTerminado($data)
    {
        try {
            $this->pdo->insert('productos_terminados', $data);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getProductoTerminadoId($idProductos)
    {
        try {
            $strSql = "SELECT pt.*, e.Estados AS EstadoNombre, mp.Nombre AS MateriaPrimaNombre 
                       FROM productos_terminados pt 
                       JOIN estados e ON pt.idEstado = e.idEstados 
                       JOIN materia_prima mp ON pt.idmateria_prima = mp.idProducto 
                       WHERE pt.idProductos = :idProductos";
            $arrayData = ['idProductos' => $idProductos];
            $query = $this->pdo->select($strSql, $arrayData);
            return $query;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function editProductoTerminado($data)
{
    try {
        $strWhere = 'idProductos = ' . $data['idProductos'];
        $this->pdo->update('productos_terminados', $data, $strWhere);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}


    public function deleteProductoTerminado($idProductos)
    {
        try {
            $strWhere = 'idProductos = :idProductos';
            $data = ['status' => 'OUT', 'idProductos' => $idProductos];
            $this->pdo->update('productos_terminados', $data, $strWhere);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getMateriasPrimas()
    {
        try {
            $strSql = "SELECT idProducto, Nombre FROM materia_prima WHERE status = 'IN'";
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
