<?php

class Database extends PDO
{
    // ⚙️ Configuración de conexión
    private string $driver = 'mysql';
    private string $host = 'texfashio-database.mysql.database.azure.com';
    private string $dbName = 'texfashion';
    private string $charset = 'utf8';
    private string $user = 'Maicol';
    private string $password = 'T4$e7rV8!';
    
    public function __construct()
    {
        $dsn = "{$this->driver}:host={$this->host};dbname={$this->dbName};charset={$this->charset}";
        
        // Configuración SSL para Azure MySQL
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            PDO::MYSQL_ATTR_SSL_CA => null, // Azure maneja SSL automáticamente
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_PERSISTENT => false
        ];

        try {
            parent::__construct($dsn, $this->user, $this->password, $options);
            echo "✅ Conexión exitosa a la base de datos Azure MySQL.";
        } catch (PDOException $e) {
            // Intentar conexión sin SSL como fallback
            echo "⚠️ Error con SSL, intentando sin SSL...\n";
            $this->connectWithoutSSL();
        }
    }
    
    private function connectWithoutSSL(): void
    {
        $dsn = "{$this->driver}:host={$this->host};dbname={$this->dbName};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 30
        ];

        try {
            parent::__construct($dsn, $this->user, $this->password, $options);
            echo "✅ Conexión exitosa sin SSL.";
        } catch (PDOException $e) {
            echo "❌ Conexión fallida: " . $e->getMessage();
            exit;
        }
    }

    public function select(string $strSql, array $arrayData = [], int $fetchMode = PDO::FETCH_OBJ): array
    {
        try {
            $query = $this->prepare($strSql);

            foreach ($arrayData as $key => $value) {
                $query->bindParam(":$key", $value);
            }

            if (!$query->execute()) {
                echo "Error, la Consulta no se Realizó";
                return [];
            }

            return $query->fetchAll($fetchMode);
        } catch (PDOException $e) {
            echo "Error en SELECT: " . $e->getMessage();
            return [];
        }
    }

    public function insert(string $table, array $data): void
    {
        try {
            ksort($data);
            unset($data['controller'], $data['method']);

            $fieldNames = implode('`, `', array_keys($data));
            $fieldValues = ':' . implode(', :', array_keys($data));
            $strSql = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

            foreach ($data as $key => $value) {
                $strSql->bindValue(":$key", $value);
            }

            $strSql->execute();
        } catch (PDOException $e) {
            die("Error en INSERT: " . $e->getMessage());
        }
    }

    public function update(string $table, array $data, string $where): void
    {
        try {
            ksort($data);
            $fieldDetails = '';

            foreach ($data as $key => $value) {
                $fieldDetails .= "`$key` = :$key,";
            }

            $fieldDetails = rtrim($fieldDetails, ',');
            $strSql = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

            foreach ($data as $key => $value) {
                $strSql->bindValue(":$key", $value);
            }

            $strSql->execute();
        } catch (PDOException $e) {
            die("Error en UPDATE: " . $e->getMessage());
        }
    }

    public function delete(string $table, string $where): int
    {
        try {
            return $this->exec("DELETE FROM $table WHERE $where");
        } catch (PDOException $e) {
            die("Error en DELETE: " . $e->getMessage());
        }
    }
}