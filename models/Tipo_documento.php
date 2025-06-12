<?php
class TipoDocumento
{
    private $pdo;

    // Constructor explícito con visibilidad
    public function __construct()
    {
        try {
            $this->pdo = new Database; // Asegúrate de tener tu clase Database funcionando
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Obtener todos los tipos de documento
    public function getAll()
    {
        try {
            $sql = "SELECT * FROM tipo_documento";
            return $this->pdo->select($sql);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Crear nuevo tipo de documento
    public function newTipoDocumento($data)
    {
        try {
            return $this->pdo->insert("tipo_documento", $data);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Obtener tipo de documento por ID
    public function getTipoDocumentoById($id)
    {
        try {
            $sql = "SELECT * FROM tipo_documento WHERE idTipoDocumento = :id";
            $params = ['id' => $id];
            return $this->pdo->select($sql, $params);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Editar tipo de documento
    public function editTipoDocumento($data)
    {
        try {
            $where = 'idTipoDocumento = ' . $data['idTipoDocumento'];
            return $this->pdo->update("tipo_documento", $data, $where);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Eliminar tipo de documento
    public function deleteTipoDocumento($id)
    {
        try {
            $where = 'idTipoDocumento = ' . $id;
            return $this->pdo->delete("tipo_documento", $where);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
