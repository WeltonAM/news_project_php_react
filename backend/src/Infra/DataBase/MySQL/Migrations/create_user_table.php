<?php

namespace Core\Infra\Database\Migrations;

use Core\Infra\Database\MySQL\MysqlPDO;

class CreateUserTable
{
    private $pdo;

    public function __construct()
    {
        $database = new MysqlPDO();
        $this->pdo = $database->getConnection();
    }

    public function up()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            email_verified_at TIMESTAMP NULL,
            password VARCHAR(255) NULL,
            remember_token VARCHAR(100) NULL,
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