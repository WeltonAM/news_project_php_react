<?php

require_once __DIR__ . '/../../../../../init.php';

use Core\Infra\Database\MySQL\MysqlPDO;
use Ramsey\Uuid\Uuid;

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
        $uuid = Uuid::uuid4()->toString();

        $sql = "
            INSERT INTO users (id, nome, email, password) VALUES (:id, :nome, :email, :password)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $uuid,
            'nome' => 'João da Silva',
            'email' => 'joao.silva@email.com',
            'password' => password_hash('!Senha123', PASSWORD_BCRYPT), 
        ]);

        echo "Usuário criado com sucesso.\n";
    }
}

$seed = new UserSeed();
$seed->run();
