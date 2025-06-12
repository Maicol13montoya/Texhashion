<?php
/**
 * Clase Categoria para gestionar registros en la tabla 'categorias'.
 */
class Categoria
{
    private $idCategoria;
    private $Categoria;
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

    // Obtener todas las categorías
    public function getAll()
    {
        try {
            $strSql = "SELECT * FROM categorias";
            $query = $this->pdo->select($strSql);
            return $query;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Crear nueva categoría
    public function newCategories($data)
    {
        try {
            $data['status_id'] = 1; // Asegúrate de tener este campo en tu tabla o elimínalo si no aplica
            $this->pdo->insert('categorias', $data);
            return true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Obtener una categoría por ID
    public function getCategoriesById($idCategoria)
    {
        try {
            $strSql = "SELECT * FROM categorias WHERE idCategoria = :idCategoria";
            $arrayData = ['idCategoria' => $idCategoria];
            $query = $this->pdo->select($strSql, $arrayData);
            return $query;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Editar categoría existente
    public function editCategories($data)
    {
        try {
            $strWhere = 'idCategoria = ' . $data['idCategoria'];
            $this->pdo->update('categorias', $data, $strWhere);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Eliminar categoría
    public function deleteCategories($data)
    {
        try {
            $strWhere = 'idCategoria = ' . $data['idCategoria'];
            $this->pdo->delete('categorias', $strWhere);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
