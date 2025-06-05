<?php

class Database extends PDO
{
    // ⚙️ Configuración de conexión
    private string $driver = 'mysql';
    private string $host = 'texfashio-database.mysql.database.azure.com';
    private string $dbName = 'texfashion';
    private string $charset = 'utf8mb4'; // Cambiado a utf8mb4 para mejor soporte Unicode
    private string $user = 'Maicol';
    private string $password = 'T4$e7rV8!'; // Mejor práctica: obtener de variable de entorno
    
    public function __construct()
    {
        // Obtener contraseña de variable de entorno por seguridad
        $this->password = $_ENV['DB_PASSWORD'] ?? 'T4$e7rV8!';
        
        $dsn = "{$this->driver}:host={$this->host};dbname={$this->dbName};charset={$this->charset}";
        
        // Configuración SSL mejorada para Azure MySQL
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            PDO::MYSQL_ATTR_SSL_CA => null, // Azure maneja SSL automáticamente
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_PERSISTENT => false
        ];

        try {
            parent::__construct($dsn, $this->user, $this->password, $options);
            // Remover echo para producción, usar logging en su lugar
            error_log("✅ Conexión exitosa a la base de datos Azure MySQL.");
        } catch (PDOException $e) {
            error_log("⚠️ Error con SSL: " . $e->getMessage());
            $this->connectWithoutSSL();
        }
    }
    
    private function connectWithoutSSL(): void
    {
        $dsn = "{$this->driver}:host={$this->host};dbname={$this->dbName};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 30
        ];

        try {
            parent::__construct($dsn, $this->user, $this->password, $options);
            error_log("✅ Conexión exitosa sin SSL.");
        } catch (PDOException $e) {
            error_log("❌ Conexión fallida: " . $e->getMessage());
            throw new Exception("No se pudo establecer conexión con la base de datos");
        }
    }

    public function select(string $strSql, array $arrayData = [], int $fetchMode = PDO::FETCH_ASSOC): array
    {
        try {
            $query = $this->prepare($strSql);

            // Mejorado: usar bindValue en lugar de bindParam para arrays
            foreach ($arrayData as $key => $value) {
                $query->bindValue(":$key", $value);
            }

            if (!$query->execute()) {
                throw new Exception("Error ejecutando la consulta SELECT");
            }

            return $query->fetchAll($fetchMode);
        } catch (PDOException $e) {
            error_log("Error en SELECT: " . $e->getMessage());
            throw new Exception("Error en consulta SELECT: " . $e->getMessage());
        }
    }

    public function insert(string $table, array $data): int
    {
        try {
            // Validar que la tabla y datos no estén vacíos
            if (empty($table) || empty($data)) {
                throw new InvalidArgumentException("Tabla y datos son requeridos");
            }

            ksort($data);
            // Filtrar campos no deseados
            $data = array_filter($data, function($key) {
                return !in_array($key, ['controller', 'method']);
            }, ARRAY_FILTER_USE_KEY);

            $fieldNames = implode('`, `', array_keys($data));
            $fieldValues = ':' . implode(', :', array_keys($data));
            $sql = "INSERT INTO `$table` (`$fieldNames`) VALUES ($fieldValues)";
            
            $stmt = $this->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return (int)$this->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error en INSERT: " . $e->getMessage());
            throw new Exception("Error en INSERT: " . $e->getMessage());
        }
    }

    public function update(string $table, array $data, string $where): bool
    {
        try {
            if (empty($table) || empty($data) || empty($where)) {
                throw new InvalidArgumentException("Tabla, datos y condición WHERE son requeridos");
            }

            ksort($data);
            $fieldDetails = '';

            foreach ($data as $key => $value) {
                $fieldDetails .= "`$key` = :$key,";
            }

            $fieldDetails = rtrim($fieldDetails, ',');
            $sql = "UPDATE `$table` SET $fieldDetails WHERE $where";
            $stmt = $this->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en UPDATE: " . $e->getMessage());
            throw new Exception("Error en UPDATE: " . $e->getMessage());
        }
    }

    public function delete(string $table, string $where): int
    {
        try {
            if (empty($table) || empty($where)) {
                throw new InvalidArgumentException("Tabla y condición WHERE son requeridos");
            }

            $sql = "DELETE FROM `$table` WHERE $where";
            return $this->exec($sql);
        } catch (PDOException $e) {
            error_log("Error en DELETE: " . $e->getMessage());
            throw new Exception("Error en DELETE: " . $e->getMessage());
        }
    }

    // Método adicional para transacciones
    public function transaction(callable $callback)
    {
        $this->beginTransaction();
        try {
            $result = $callback($this);
            $this->commit();
            return $result;
        } catch (Exception $e) {
            $this->rollback();
            throw $e;
        }
    }

    // Método para verificar la conexión
    public function isConnected(): bool
    {
        try {
            $this->query('SELECT 1');
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}