<?php

/**
 * 
 */
class Estado
{
	private $idEstados;
	private $Estados;
	private $pdo;
	
	function __construct()
	{
		try {
			$this->pdo =new Database;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function getALL()
	{
		try {
			$strSql = "SELECT * FROM estados";
			$query =$this->pdo->select($strSql);
			return $query;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}	

	public function newEstados($data)
	{

	    try {
	    	$data['status_id'] =1;
	    	$this->pdo->insert('estados',$data);
			return true;
		} catch (PDOException $e) {
			die($e->getMessage());
		}

	}

	public function getEstadosById($idEstados)
		{
			try {
				$strSql = "SELECT * FROM estados WHERE idEstados = :idEstados";
				$arrayData = ['idEstados' => $idEstados];
				$query = $this->pdo->select($strSql, $arrayData);
				return $query; 
			} catch(PDOException $e) {
				die($e->getMessage());
			}	
		}

		public function editEstados($data)
		{
			try {
				$strWhere = 'idEstados = '. $data['idEstados'];
				$this->pdo->update('estados', $data, $strWhere);				
			} catch(PDOException $e) {
				die($e->getMessage());
			}		
		}

		public function deleteEstados($data)
		{
			try {
				$strWhere = 'idEstados = '. $data['idEstados'];
				$this->pdo->delete('estados', $strWhere);
			} catch(PDOException $e) {
				die($e->getMessage());
			}	
		}
}