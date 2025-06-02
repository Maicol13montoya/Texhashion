<?php

class Usuarios
{
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
            $sql = "SELECT u.*, r.Rol, d.TipoDocumento 
                    FROM usuario u 
                    JOIN rol r ON u.rol = r.idRol 
                    JOIN documento d ON u.tipo_documento = d.IdDocumento";
            return $this->pdo->select($sql);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getUsuariosId($id)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE id = :id";
            return $this->pdo->select($sql, ['id' => $id]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function newUsuarios($data)
    {
        try {
            $this->pdo->insert('usuario', $data);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function editUsuarios($data)
    {
        try {
            $where = 'id = ' . $data['id'];
            return $this->pdo->update('usuario', $data, $where);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteUsuarios($id)
    {
        try {
            $where = 'id = ' . intval($id);
            return $this->pdo->delete('usuario', $where);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function obtenerCorreoPorId($id)
    {
        try {
            $sql = "SELECT correo_electronico FROM usuario WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    // Este es el método que estabas intentando agregar
    public function getTAll()
    {
        try {
            $sql = "SELECT id, nombre, apellido FROM usuario WHERE rol = 4 AND status = 'IN'";
            return $this->pdo->select($sql);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
