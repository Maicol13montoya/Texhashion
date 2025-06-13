<?php

class Database extends PDO
{
    private string $driver;
    private string $host;
    private string $dbName;
    private string $charset;
    private string $user;
    private string $password;

    public function __construct()
    {
        // Cargar configuración desde archivo externo
        $config = require 'config_db.php';

        $this->driver = $config['driver'];
        $this->host = $config['host'];
        $this->dbName = $config['dbname'];
        $this->charset = $config['charset'];
        $this->user = $config['user'];
        $this->password = $config['password'];

        $dsn = "{$this->driver}:host={$this->host};dbname={$this->dbName};charset={$this->charset}";

        $sslOptions = defined('PDO::MYSQL_ATTR_SSL_CA') ? [
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            PDO::MYSQL_ATTR_SSL_CA => null
        ] : [];

        $options = array_replace([
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 30,
            PDO::ATTR_PERSISTENT         => false
        ], $sslOptions);

        try {
            parent::__construct($dsn, $this->user, $this->password, $options);
            error_log("✅ Conexión exitosa con SSL.");
        } catch (PDOException $e) {
            error_log("⚠️ Falló conexión con SSL: " . $e->getMessage());
            try {
                $this->connectWithoutSSL($dsn);
            } catch (PDOException $e2) {
                die("❌ No se pudo conectar a la base de datos: " . $e2->getMessage());
            }
        }
    }

    private function connectWithoutSSL(string $dsn): void
    {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 30
        ];

        parent::__construct($dsn, $this->user, $this->password, $options);
        error_log("✅ Conexión exitosa sin SSL.");
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
            error_log("❌ Error en SELECT: " . $e->getMessage());
            throw new Exception("Error en SELECT: " . $e->getMessage());
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

            $fields = implode('`, `', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $sql = "INSERT INTO `$table` (`$fields`) VALUES ($placeholders)";
            $stmt = $this->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return (int) $this->lastInsertId();
        } catch (PDOException $e) {
            error_log("❌ Error en INSERT: " . $e->getMessage());
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
            $setClause = implode(', ', array_map(fn($k) => "`$k` = :$k", array_keys($data)));

            $sql = "UPDATE `$table` SET $setClause WHERE $where";
            $stmt = $this->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("❌ Error en UPDATE: " . $e->getMessage());
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
            error_log("❌ Error en DELETE: " . $e->getMessage());
            throw new Exception("Error en DELETE: " . $e->getMessage());
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
            $this->rollback();
            throw $e;
        }
    }

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
