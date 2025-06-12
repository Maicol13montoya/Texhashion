<?php
/**
 * Clase para gestionar unidad de medida
 */
class UnidadaMedida
{
	private $MedidaID;
	private $Estados;
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

	public function getALL()
	{
		try {
			$strSql = "SELECT * FROM unidadmedida";
			$query = $this->pdo->select($strSql);
			return $query;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function newUnidadMedida($data)
	{
	    try {
	    	$this->pdo->insert('unidadmedida', $data);
			return true;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function getUnidadMedidaById($MedidaID)
	{
		try {
			$strSql = "SELECT * FROM unidadmedida WHERE MedidaID = :MedidaID";
			$arrayData = ['MedidaID' => $MedidaID];
			$query = $this->pdo->select($strSql, $arrayData);
			return $query;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function editUnidadMedida($data)
	{
		try {
			$strWhere = 'MedidaID = ' . $data['MedidaID'];
			$this->pdo->update('unidadmedida', $data, $strWhere);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function deleteUnidadMedida($data)
	{
		try {
			$strWhere = 'MedidaID = ' . $data['MedidaID'];
			$this->pdo->delete('unidadmedida', $strWhere);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
}
