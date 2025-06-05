<?php

class Database extends PDO
{
    public function __construct()
    {
        // Configuración de conexión (usa variables locales para evitar sobrescribir propiedades)
        $driver = 'mysql';
        $host = 'texfashio-database.mysql.database.azure.com';
        $dbName = 'texfashion';
        $charset = 'utf8mb4';
        $user = 'Maicol';
        $password = $_ENV['DB_PASSWORD'] ?? 'T4$e7rV8!';

        $dsn = "$driver:host=$host;dbname=$dbName;charset=$charset";

        // Opciones con SSL opcional (si constante definida)
        $sslOptions = defined('PDO::MYSQL_ATTR_SSL_CA') ? [
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            PDO::MYSQL_ATTR_SSL_CA => null
        ] : [];

        $options = array_replace([
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_PERSISTENT => false
        ], $sslOptions);

        try {
            parent::__construct($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            error_log("⚠️ Error con SSL: " . $e->getMessage());
            $this->connectWithoutSSL($dsn, $user, $password);
        }
    }

    private function connectWithoutSSL(string $dsn, string $user, string $password): void
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 30
        ];

        try {
            parent::__construct($dsn, $user, $password, $options);
            error_log("✅ Conexión exitosa sin SSL.");
        } catch (PDOException $e) {
            error_log("❌ Conexión fallida: " . $e->getMessage());
            throw new Exception("No se pudo establecer conexión con la base de datos");
        }
    }

    public function select(string $sql, array $params = [], int $fetchMode = PDO::FETCH_ASSOC): array
    {
        try {
            $stmt = $this->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return $stmt->fetchAll($fetchMode);
        } catch (PDOException $e) {
            error_log("Error en SELECT: " . $e->getMessage());
            throw new Exception("Error en consulta SELECT");
        }
    }

    public function insert(string $table, array $data): int
    {
        try {
            if (empty($table) || empty($data)) {
                throw new InvalidArgumentException("Tabla y datos son requeridos");
            }

            $data = array_filter($data, fn($key) => !in_array($key, ['controller', 'method']), ARRAY_FILTER_USE_KEY);
            ksort($data);

            $columns = implode('`, `', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $sql = "INSERT INTO `$table` (`$columns`) VALUES ($placeholders)";
            $stmt = $this->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return (int) $this->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error en INSERT: " . $e->getMessage());
            throw new Exception("Error en INSERT");
        }
    }

    public function update(string $table, array $data, string $where, array $params = []): bool
    {
        try {
            if (empty($table) || empty($data) || empty($where)) {
                throw new InvalidArgumentException("Tabla, datos y condición WHERE son requeridos");
            }

            ksort($data);
            $set = implode(', ', array_map(fn($key) => "`$key` = :$key", array_keys($data)));

            $sql = "UPDATE `$table` SET $set WHERE $where";
            $stmt = $this->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en UPDATE: " . $e->getMessage());
            throw new Exception("Error en UPDATE");
        }
    }

    public function delete(string $table, string $where, array $params = []): int
    {
        try {
            if (empty($table) || empty($where)) {
                throw new InvalidArgumentException("Tabla y condición WHERE son requeridos");
            }

            $sql = "DELETE FROM `$table` WHERE $where";
            $stmt = $this->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log("Error en DELETE: " . $e->getMessage());
            throw new Exception("Error en DELETE");
        }
    }

    public function transaction(callable $callback)
    {
        $this->beginTransaction();
        try {
            $result = $callback($this);
            $this->commit();
            return $result;
        } catch (Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

    public function isConnected(): bool
    {
        try {
            $this->query('SELECT 1');
            return true;
        } catch (PDOException) {
            return false;
        }
    }
}
