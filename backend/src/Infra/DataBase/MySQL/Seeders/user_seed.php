<?php

require_once __DIR__ . '/../../../../../init.php';

use Core\Infra\Database\MySQL\MysqlPDO;

class UserSeed
{
    private $pdo;

    public function __construct()
    {
        $database = new MysqlPDO();
        $this->pdo = $database->getConnection();
    }

    public function run()
    {
        $sql = "
            INSERT INTO users (nome, email, password) VALUES (:nome, :email, :password)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'nome' => 'João da Silva',
            'email' => 'joao.silva@email.com',
            'password' => password_hash('!Senha123', PASSWORD_BCRYPT), 
        ]);

        echo "Usuário criado com sucesso.\n";
    }
}

$seed = new UserSeed();
$seed->run();
