<?php
/**
 * Clase Estado para gestionar registros en la tabla 'estados'.
 */
class Estado
{
    private $idEstados;
    private $Estados;
    private $pdo;

    // Constructor explícitamente público
    public function __construct()
    {
        try {
            $this->pdo = new Database;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Obtener todos los registros de estados
    public function getAll()
    {
        try {
            $strSql = "SELECT * FROM estados";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Crear nuevo estado
    public function newEstados($data)
    {
        try {
            $data['status_id'] = 1; // Si no usas este campo, puedes eliminar esta línea
            $this->pdo->insert('estados', $data);
            return true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Obtener estado por ID
    public function getEstadosById($idEstados)
    {
        try {
            $strSql = "SELECT * FROM estados WHERE idEstados = :idEstados";
            $arrayData = ['idEstados' => $idEstados];
            $query = $this->pdo->select($strSql, $arrayData);
            return $query;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Editar estado
    public function editEstados($data)
    {
        try {
            $strWhere = 'idEstados = ' . $data['idEstados'];
            $this->pdo->update('estados', $data, $strWhere);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Eliminar estado
    public function deleteEstados($data)
    {
        try {
            $strWhere = 'idEstados = ' . $data['idEstados'];
            $this->pdo->delete('estados', $strWhere);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
