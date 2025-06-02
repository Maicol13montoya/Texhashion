<?php

class MateriaPrima
{
    private $idProducto;
    private $Nombre;
    private $Descripcion;
    private $Fecha_Ingreso;
    private $Precio_Unidad;
    private $Cantidad_Stock;
    private $id_Proveedor;
    private $Categoria;
    private $Unidad_Medida;
    private $Fecha_Actualizacion;
    private $Estado;
    private $status;
    private $pdo;

    function __construct()
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
            $strSql = "SELECT mp.*, e.Estados AS EstadoNombre, c.Categoria AS CategoriaNombre, um.Uni_Med AS UnidadMedidaNombre, 
            u.nombre AS ProveedorNombre, u.apellido AS ProveedorApellido FROM materia_prima mp JOIN estados e ON mp.Estado = e.idEstados 
            JOIN categorias c ON mp.Categoria = c.idCategoria JOIN unidadmedida um ON mp.Unidad_Medida = um.MedidaId 
            JOIN usuario u ON mp.id_Proveedor = u.id WHERE MP.status = 'IN'";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function newMateriaPrima($data)
    {
        try {
            $this->pdo->insert('materia_prima', $data);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getMateriaPrimaId($idProducto)
    {
        try {
            $strSql = "SELECT MP.*, E.Estados AS EstadoNombre, C.Categoria AS CategoriaNombre, UM.Uni_Med AS UnidadMedidaNombre, U.nombre AS ProveedorNombre, U.apellido AS ProveedorApellido  FROM materia_prima AS MP INNER JOIN categorias AS C ON C.idCategoria = MP.Categoria INNER JOIN unidadmedida AS UM ON UM.MedidaID = MP.Unidad_Medida INNER JOIN estados AS E ON E.idEstados = MP.Estado INNER JOIN usuario AS U ON U.id = MP.id_Proveedor WHERE MP.idProducto = :idProducto ";
            $arrayData = ['idProducto' => $idProducto];
            $query = $this->pdo->select($strSql, $arrayData);
            return $query;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function editMateriaPrima($data)
    {
        try {
            $strWhere = 'idProducto = ' . $data['idProducto'];
            $this->pdo->update('materia_prima', $data, $strWhere);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteMateriaPrima($idProducto)
    {
        try {
            // Cambia la consulta para que se ajuste al método que estás usando
            $strWhere = 'idProducto = :idProducto';
            $data = ['status' => 'OUT', 'idProducto' => $idProducto];

            // Asegúrate de que tu método update esté manejando los parámetros correctamente
            $this->pdo->update('materia_prima', $data, $strWhere);

            return true; // Indica que la operación fue exitosa
        } catch (PDOException $e) {
            return $e->getMessage(); // Devuelve el mensaje de error
        }
    }



    public function getProveedores($Proveedor)
    {
        try {
            $strSql = "SELECT id, nombre, apellido FROM usuario WHERE Rol = 5";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getCategorias($Categoria)
    {
        try {
            $strSql = "SELECT idCategoria, Categoria FROM categorias";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

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

    public function getUnidadMedida($UniMed)
    {
        try {
            $strSql = "SELECT MedidaID, Uni_Med FROM unidadmedida";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
