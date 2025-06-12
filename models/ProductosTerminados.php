<?php
class ProductosTerminados
{
	private $idProductos;
	private $Nombre_Producto;
	private $Descripcion;
	private $Fecha_Entrada;
	private $Fecha_Salida;
	private $idmateria_prima;
	private $idEstado;
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

	// Método para obtener todos los productos terminados
	public function getALL()
	{
		try {
			$strSql = "SELECT * FROM productos_terminados";
			$query = $this->pdo->select($strSql);
			return $query;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
}

