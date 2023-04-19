<?php

namespace App\Models;

use PDO;

class Database
{
    private PDO $connection;
    private static ?Database $instance = null;

    /**
     * Создает новый экземпляр класса Database.
     */
    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $driver = $config['default'];
        $config = $config['connections'][$driver];
        $host = $config['host'] ?? null;
        $database = $config['database'];
        $username = $config['username'] ?? null;
        $password = $config['password'] ?? null;
        $charset = $config['charset'] ?? 'utf8';
        $collation = $config['collation'] ?? 'utf8_general_ci';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $dsn = "$driver:$database";
        if ($driver === 'mysql') {
            $dsn .= "dbname=$database;host=$host;charset=$charset";
            $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES $charset COLLATE $collation";
        } else if ($driver !== 'sqlite') {
            throw new \InvalidArgumentException("Unsupported database driver: $driver");
        }
        $this->connection = new PDO($dsn, $username, $password, $options);
    }

    /**
     * Возвращает единственный экземпляр класса Database.
     *
     * @return Database|null
     */
    public static function getInstance(): ?Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Возвращает объект PDO для работы с базой данных.
     *
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Выполняет SQL-запрос к базе данных.
     *
     * @param string $query SQL-запрос.
     * @param array $params Параметры запроса.
     *
     * @return bool|\PDOStatement
     */
    public function query(string $query, array $params = [])
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
}
