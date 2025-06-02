<?php

/**
 * 
 */
class Categoria
{
	private $idCategoria;
	private $Categoria;
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
			$strSql = "SELECT * FROM categorias";
			$query =$this->pdo->select($strSql);
			return $query;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}	

	public function newCategories($data)
	{

	    try {
	    	$data['status_id'] =1;
	    	$this->pdo->insert('categorias',$data);
			return true;
		} catch (PDOException $e) {
			die($e->getMessage());
		}

	}

	public function getCategoriesById($idCategoria)
		{
			try {
				$strSql = "SELECT * FROM categorias WHERE idCategoria = :idCategoria";
				$arrayData = ['idCategoria' => $idCategoria];
				$query = $this->pdo->select($strSql, $arrayData);
				return $query; 
			} catch(PDOException $e) {
				die($e->getMessage());
			}	
		}

		public function editCategories($data)
		{
			try {
				$strWhere = 'idCategoria = '. $data['idCategoria'];
				$this->pdo->update('categorias', $data, $strWhere);				
			} catch(PDOException $e) {
				die($e->getMessage());
			}		
		}

		public function deleteCategories($data)
		{
			try {
				$strWhere = 'idCategoria = '. $data['idCategoria'];
				$this->pdo->delete('categorias', $strWhere);
			} catch(PDOException $e) {
				die($e->getMessage());
			}	
		}
}