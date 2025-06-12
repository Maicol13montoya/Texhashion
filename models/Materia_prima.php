<?php
class MateriaPrima
{
    private $idProducto;
    private $Nombre;
    private $Descripcion;
    private $Fecha_Ingreso;
    private $Cantidad_Stock;
    private $id_Proveedor;
    private $Categoria;
    private $Unidad_Medida;
    private $Fecha_Actualizacion;
    private $Estado;
    private $pdo;

    // Constructor
    public function __construct()
    {
        try {
            $this->pdo = new Database();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Obtener todos los registros activos
    public function obtenerTodo()
    {
        try {
            $strSql = "SELECT mp.*,
                              e.Estados AS EstadoNombre,
                              c.Categoria AS CategoriaNombre,
                              um.Uni_Med AS UnidadMedidaNombre,
                              u.nombre AS ProveedorNombre,
                              u.apellido AS ProveedorApellido
                       FROM materia_prima mp
                       JOIN estados e ON mp.Estado = e.idEstados
                       JOIN categorias c ON mp.Categoria = c.idCategoria
                       JOIN unidadmedida um ON mp.Unidad_Medida = um.MedidaID
                       JOIN usuario u ON mp.id_Proveedor = u.id
                       WHERE mp.estado = 'IN'";
            return $this->pdo->seleccionar($strSql);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Crear nueva materia prima
    public function nuevaMateriaPrima($datos)
    {
        try {
            $this->pdo->insertar('materia_prima', $datos);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // Obtener materia prima por ID
    public function obtenerMateriaPrimaId($idProducto)
    {
        try {
            $strSql = "SELECT mp.*,
                              e.Estados AS EstadoNombre,
                              c.Categoria AS CategoriaNombre,
                              um.Uni_Med AS UnidadMedidaNombre,
                              u.nombre AS ProveedorNombre,
                              u.apellido AS ProveedorApellido
                       FROM materia_prima mp
                       JOIN categorias c ON c.idCategoria = mp.Categoria
                       JOIN unidadmedida um ON um.MedidaID = mp.Unidad_Medida
                       JOIN estados e ON e.idEstados = mp.Estado
                       JOIN usuario u ON u.id = mp.id_Proveedor
                       WHERE mp.idProducto = :idProducto";
            return $this->pdo->seleccionar($strSql, ['idProducto' => $idProducto]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Editar materia prima existente
    public function editarMateriaPrima($datos)
    {
        try {
            $strWhere = 'idProducto = ' . $datos['idProducto'];
            $this->pdo->actualizar('materia_prima', $datos, $strWhere);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Eliminar (lógicamente) materia prima
    public function eliminarMateriaPrima($idProducto)
    {
        try {
            $datos = ['estado' => 'OUT'];
            $strWhere = 'idProducto = ' . $idProducto;
            $this->pdo->actualizar('materia_prima', $datos, $strWhere);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // Obtener lista de proveedores con rol 5
    public function obtenerProveedores()
    {
        try {
            $strSql = "SELECT id, nombre, apellido FROM usuario WHERE Rol = 5";
            return $this->pdo->seleccionar($strSql);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // Obtener lista de categorías
    public function obtenerCategorias()
    {
        try {
            $strSql = "SELECT idCategoria, Categoria FROM categorias";
            return $this->pdo->seleccionar($strSql);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // Obtener lista de estados
    public function obtenerEstados()
    {
        try {
            $strSql = "SELECT idEstados, Estados FROM estados";
            return $this->pdo->seleccionar($strSql);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // Obtener lista de unidades de medida
    public function obtenerUnidadMedida()
    {
        try {
            $strSql = "SELECT MedidaID, Uni_Med FROM unidadmedida";
            return $this->pdo->seleccionar($strSql);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}

