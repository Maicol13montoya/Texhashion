<?php

class Database extends PDO
{
    private string $driver = 'mysql';
    private string $host = 'texfashio.mysql.database.azure.com';
    private string $dbName = 'textfashion';
    private string $charset = 'utf8mb4';
    private string $user = 'maicol';
    private string $password = 'root*25*';

    public function __construct()
    {
        // MEJORADO: Múltiples formas de obtener la contraseña para Azure
        $this->password = $this->getPassword();

        // Log para debug en Azure
        error_log("🔍 Intentando conectar a: {$this->host}");
        error_log("🔍 Usuario: {$this->user}");
        error_log("🔍 Base de datos: {$this->dbName}");

        $dsn = "{$this->driver}:host={$this->host};dbname={$this->dbName};charset={$this->charset}";

        // Opciones específicas para Azure MySQL
        $sslOptions = [
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            PDO::MYSQL_ATTR_SSL_CA => null,
            PDO::MYSQL_ATTR_SSL_CIPHER => null
        ];

        $options = array_merge([
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // CAMBIO: FETCH_OBJ para coincidir con tu vista
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_PERSISTENT => false
        ], $sslOptions);

        try {
            parent::__construct($dsn, $this->user, $this->password, $options);
            error_log("✅ Conexión exitosa con SSL a Azure MySQL");
        } catch (PDOException $e) {
            error_log("⚠️ Falló conexión con SSL: " . $e->getMessage());
            try {
                $this->connectWithoutSSL($dsn);
            } catch (PDOException $e2) {
                error_log("❌ Error final de conexión: " . $e2->getMessage());
                die("❌ No se pudo conectar a Azure MySQL: " . $e2->getMessage());
            }
        }
    }

    private function getPassword(): string
    {
        // Prioridad de configuración para Azure
        // 1. Variable de entorno del sistema
        if (!empty($_ENV['DB_PASSWORD'])) {
            return $_ENV['DB_PASSWORD'];
        }

        // 2. Variable de servidor (Azure App Service)
        if (!empty($_SERVER['DB_PASSWORD'])) {
            return $_SERVER['DB_PASSWORD'];
        }

        // 3. getenv() function
        $envPassword = getenv('DB_PASSWORD');
        if ($envPassword !== false) {
            return $envPassword;
        }

        // 4. Archivo .env si existe (para desarrollo local)
        if (file_exists('.env')) {
            $env = parse_ini_file('.env');
            if (isset($env['DB_PASSWORD'])) {
                return $env['DB_PASSWORD'];
            }
        }

        // 5. Valor por defecto - CAMBIAR por tu contraseña real de Azure
        error_log("⚠️ Usando contraseña por defecto - configurar DB_PASSWORD en Azure");
        return 'TU_CONTRASEÑA_AZURE_AQUI'; // CAMBIAR ESTO
    }

    private function connectWithoutSSL(string $dsn): void
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // CAMBIO: FETCH_OBJ
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 30
        ];

        try {
            parent::__construct($dsn, $this->user, $this->password, $options);
            error_log("✅ Conexión exitosa sin SSL a Azure MySQL");
        } catch (PDOException $e) {
            throw new PDOException("Fallo al conectar sin SSL: " . $e->getMessage());
        }
    }

    public function select(string $strSql, array $arrayData = [], int $fetchMode = PDO::FETCH_OBJ): array
    {
        try {
            error_log("🔍 Ejecutando SQL: " . $strSql);

            $query = $this->prepare($strSql);
            foreach ($arrayData as $key => $value) {
                $query->bindValue(":$key", $value);
            }
            $query->execute();

            $result = $query->fetchAll($fetchMode);
            error_log("✅ Consulta exitosa, registros encontrados: " . count($result));

            return $result;
        } catch (PDOException $e) {
            error_log("❌ Error en SELECT: " . $e->getMessage());
            error_log("❌ SQL: " . $strSql);
            throw new Exception("Error en consulta SELECT: " . $e->getMessage());
        }
    }

    // Test específico para tu consulta de usuarios
    public function testUsuariosQuery(): array
    {
        try {
            $sql = "SELECT u.*, r.Rol, d.TipoDocumento 
                    FROM usuario u 
                    JOIN rol r ON u.rol = r.idRol 
                    JOIN documento d ON u.tipo_documento = d.IdDocumento
                    LIMIT 5"; // Limitar para test

            error_log("🧪 Test query usuarios: " . $sql);
            return $this->select($sql);
        } catch (Exception $e) {
            error_log("❌ Error en test usuarios: " . $e->getMessage());
            return [];
        }
    }

    // Resto de métodos sin cambios
    public function insert(string $table, array $data): int
    {
        try {
            if (empty($table) || empty($data)) {
                throw new InvalidArgumentException("Tabla y datos son requeridos");
            }

            $data = array_filter($data, function ($key) {
                return !in_array($key, ['controller', 'method']);
            }, ARRAY_FILTER_USE_KEY);

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

// TEST DE CONEXIÓN PARA AZURE
try {
    $db = new Database();
    if ($db->isConnected()) {
        echo "✅ Conexión exitosa a Azure MySQL<br>";

        // Test específico de usuarios
        $usuarios = $db->testUsuariosQuery();
        echo "👥 Usuarios encontrados: " . count($usuarios) . "<br>";

        if (!empty($usuarios)) {
            echo "📋 Primer usuario: " . print_r($usuarios[0], true);
        }
    } else {
        echo "❌ Conexión fallida a Azure MySQL";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
