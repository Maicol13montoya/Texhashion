<?php
class Rol
{
    private $idRol;
    private $Rol;
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

    // Método para obtener todos los roles
    public function getALL()
    {
        try {
            $strSql = "SELECT * FROM rol";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
