<?php

require 'models/Index.php';

/**
 * Clase Controlador Login
 */
class IndexController
{
	//atributo para que me conecte al modelo
	private $model;

	//llamado del constructor
	public function __construct()
	{
		//instancia
		$this->model = new Index;
	}


	public function index()
	{
		require 'views/index.php';
	}
}
