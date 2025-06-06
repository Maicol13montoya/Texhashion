<?php

class Database extends PDO
{
    private string $driver = 'mysql';
    private string $host = 'texfashio.mysql.database.azure.com';
    private string $dbName = 'textfashion';
    private string $charset = 'utf8mb4';
    private string $user = 'maicol';
    private string $password = 'root*25*'; // << Aquí está la contraseña directamente

    public function __construct()
    {
        $dsn = "{$this->driver}:host={$this->host};dbname={$this->dbName};charset={$this->charset}";

        $sslOptions = [
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            PDO::MYSQL_ATTR_SSL_CA => null,
            PDO::MYSQL_ATTR_SSL_CIPHER => null
        ];

        $options = array_merge([
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_PERSISTENT => false
        ], $sslOptions);

        try {
            parent::__construct($dsn, $this->user, $this->password, $options);
            error_log("✅ Conexión exitosa con SSL a Azure MySQL");
        } catch (PDOException $e) {
            error_log("⚠️ Falló conexión con SSL: " . $e->getMessage());
            $this->connectWithoutSSL($dsn);
        }
    }

    private function connectWithoutSSL(string $dsn): void
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 30
        ];

        parent::__construct($dsn, $this->user, $this->password, $options);
        error_log("✅ Conexión exitosa sin SSL a Azure MySQL");
    }

    public function select(string $strSql, array $arrayData = [], int $fetchMode = PDO::FETCH_OBJ): array
    {
        try {
            $query = $this->prepare($strSql);
            foreach ($arrayData as $key => $value) {
                $query->bindValue(":$key", $value);
            }
            $query->execute();
            return $query->fetchAll($fetchMode);
        } catch (PDOException $e) {
            error_log("❌ Error en SELECT: " . $e->getMessage());
            throw new Exception("Error en consulta SELECT: " . $e->getMessage());
        }
    }

    public function insert(string $table, array $data): int
    {
        try {
            $data = array_filter($data, fn($k) => !in_array($k, ['controller', 'method']), ARRAY_FILTER_USE_KEY);
            ksort($data);

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
            throw new Exception("Error en INSERT: " . $e->getMessage());
        }
    }

    public function update(string $table, array $data, string $where): bool
    {
        try {
            ksort($data);
            $fieldDetails = implode(', ', array_map(fn($k) => "`$k` = :$k", array_keys($data)));

            $sql = "UPDATE `$table` SET $fieldDetails WHERE $where";
            $stmt = $this->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error en UPDATE: " . $e->getMessage());
        }
    }

    public function delete(string $table, string $where): int
    {
        try {
            $sql = "DELETE FROM `$table` WHERE $where";
            return $this->exec($sql);
        } catch (PDOException $e) {
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

    public function testUsuariosQuery(): array
    {
        $sql = "SELECT u.*, r.Rol, d.TipoDocumento 
                FROM usuario u 
                JOIN rol r ON u.rol = r.idRol 
                JOIN documento d ON u.tipo_documento = d.IdDocumento
                LIMIT 5";
        return $this->select($sql);
    }
}

// PRUEBA
try {
    $db = new Database();
    if ($db->isConnected()) {
        echo "✅ Conexión exitosa a Azure MySQL<br>";

        $usuarios = $db->testUsuariosQuery();
        echo "👥 Usuarios encontrados: " . count($usuarios) . "<br>";

        if (!empty($usuarios)) {
            echo "📋 Primer usuario: <pre>" . print_r($usuarios[0], true) . "</pre>";
        }
    } else {
        echo "❌ Conexión fallida a Azure MySQL";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
