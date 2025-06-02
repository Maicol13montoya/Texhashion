<?php

/**
 * 
 */
class Rol
{
	private $idRol;
	private $Rol;
	private $pdo;

	function __construct()
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
			$strSql = "SELECT * FROM rol";
			$query = $this->pdo->select($strSql);
			return $query;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
}
