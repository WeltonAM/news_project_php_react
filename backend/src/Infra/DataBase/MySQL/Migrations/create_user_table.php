<?php

require_once __DIR__ . '/../../../../../init.php';

use Core\Infra\Database\MySQL\MysqlPDO;

class CreateUserTable
{
    private $pdo;

    public function __construct()
    {
        $database = new MysqlPDO();     
        var_dump('DATABASE');
        $this->pdo = $database->getConnection();
    }

    public function up()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
        ";

        try {
            $this->pdo->exec($sql);
            echo "Tabela 'users' criada com sucesso.\n";
        } catch (\PDOException $e) {
            echo "Erro ao criar tabela 'users': " . $e->getMessage() . "\n";
        }
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS users";

        try {
            $this->pdo->exec($sql);
            echo "Tabela 'users' removida com sucesso.\n";
        } catch (\PDOException $e) {
            echo "Erro ao remover tabela 'users': " . $e->getMessage() . "\n";
        }
    }
}

$migration = new CreateUserTable();
$migration->up();  
// Use $migration->down(); para reverter a migração