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
            $strSql = "SELECT mp.*, e.Estados AS EstadoNombre, c.Categoria AS CategoriaNombre, 
                              um.Uni_Med AS UnidadMedidaNombre, u.nombre AS ProveedorNombre, 
                              u.apellido AS ProveedorApellido 
                       FROM materia_prima mp 
                       JOIN estados e ON mp.Estado = e.idEstados 
                       JOIN categorias c ON mp.Categoria = c.idCategoria 
                       JOIN unidadmedida um ON mp.Unidad_Medida = um.MedidaId 
                       JOIN usuario u ON mp.id_Proveedor = u.id 
                       WHERE mp.status = 'IN'";
            return $this->pdo->select($strSql);
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
            $strSql = "SELECT MP.*, E.Estados AS EstadoNombre, C.Categoria AS CategoriaNombre, 
                              UM.Uni_Med AS UnidadMedidaNombre, U.nombre AS ProveedorNombre, 
                              U.apellido AS ProveedorApellido  
                       FROM materia_prima AS MP 
                       INNER JOIN categorias AS C ON C.idCategoria = MP.Categoria 
                       INNER JOIN unidadmedida AS UM ON UM.MedidaID = MP.Unidad_Medida 
                       INNER JOIN estados AS E ON E.idEstados = MP.Estado 
                       INNER JOIN usuario AS U ON U.id = MP.id_Proveedor 
                       WHERE MP.idProducto = :idProducto";
            $arrayData = ['idProducto' => $idProducto];
            return $this->pdo->select($strSql, $arrayData);
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
            $strWhere = 'idProducto = :idProducto';
            $data = ['status' => 'OUT', 'idProducto' => $idProducto];
            $this->pdo->update('materia_prima', $data, $strWhere);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getProveedores()
    {
        try {
            $strSql = "SELECT id, nombre, apellido FROM usuario WHERE Rol = 5";
            return $this->pdo->select($strSql);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getCategorias()
    {
        try {
            $strSql = "SELECT idCategoria, Categoria FROM categorias";
            return $this->pdo->select($strSql);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getEstados()
    {
        try {
            $strSql = "SELECT idEstados, Estados FROM estados";
            return $this->pdo->select($strSql);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getUnidadMedida()
    {
        try {
            $strSql = "SELECT MedidaID, Uni_Med FROM unidadmedida";
            return $this->pdo->select($strSql);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
