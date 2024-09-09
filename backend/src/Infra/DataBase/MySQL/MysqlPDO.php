<?php

namespace Core\Infra\Database\MySQL;

class MysqlPDO
{
    private $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/../../../Infra/config.php';
        
        $dbConfig = $config['connections']['mysql'];
        
        $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['database']}";

        try {
            $this->pdo = new \PDO($dsn, $dbConfig['username'], $dbConfig['password']);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
