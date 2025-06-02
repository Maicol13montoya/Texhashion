<?php

/**
 * modelo de Login
 */
class Login
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

    //como llegan todos los datos lo llamamos data
    public function validateUser($data)
    {
        try {
            // Encriptar la contraseña ingresada con MD5
            $hashedPassword = md5($data['password']); // Asegúrate de que el campo del formulario sea 'password'

            //consulta para validar si el usuario existe o no
            $strSql = "SELECT id, correo_electronico, contrasena AS encrypted_password, rol FROM usuario WHERE correo_electronico = '{$data['email']}'";

            //se ejecuta la consulta   se pasa como parametro la consulta
            $query = $this->pdo->select($strSql);

            //validacion
            //si existe el id 
            if (isset($query[0]->id)) {
                // Validar si la contraseña coincide
                if ($query[0]->encrypted_password === $hashedPassword) {
                    //si lo encuentra me retorna un verdadero
                    return $query[0];
                } else {
                    return 'Error al Iniciar Sesión. Verifique sus Credenciales';
                }
            } else {
                return 'Error al Iniciar Sesión. usuario no existe';
            } //si es falso reorna error

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
