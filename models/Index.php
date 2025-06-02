<?php

/**
 * modelo de Login
 */
class Index
{
    //variable pdo
    private $pdo;

    //metodo constructor
    public function __construct()
    {
        try {
            $this->pdo = new Database;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
