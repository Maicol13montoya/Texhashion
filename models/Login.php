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
            // Limpiar espacios en blanco
            $email = trim($data['email']);
            $password = trim($data['password']);

            // Encriptar la contraseña ingresada con MD5
            $hashedPassword = md5($password);

            // Consulta SQL
            $strSql = "SELECT id, correo_electronico, TRIM(contrasena) AS encrypted_password, rol 
                   FROM usuario 
                   WHERE correo_electronico = '{$email}'";

            // Ejecutar la consulta
            $query = $this->pdo->select($strSql);

            // Verifica si el usuario existe
            if (isset($query[0])) {

                // Contraseña almacenada en la base
                $storedPassword = trim($query[0]['encrypted_password']);

                // Comparar la contraseña
                if ($storedPassword === $hashedPassword) {
                    return $query[0]; // Autenticación exitosa
                } else {
                    return 'Error al Iniciar Sesión. Verifique sus Credenciales'; // Contraseña incorrecta
                }
            } else {
                return 'Error al Iniciar Sesión. Usuario no existe'; // No se encontró el correo
            }
        } catch (PDOException $e) {
            return 'Error en la base de datos: ' . $e->getMessage();
        }
    }
}
