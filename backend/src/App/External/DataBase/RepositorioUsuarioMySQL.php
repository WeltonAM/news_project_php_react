<?php

namespace Core\App\External\DataBase;

use Core\Domain\User\Provider\RepositorioUsuario;
use Core\Domain\User\Model\Usuario;
use Core\Infra\Database\MySQL\MysqlPDO;
use PDO;

class RepositorioUsuarioMySQL implements RepositorioUsuario
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new MysqlPDO();
        $this->pdo = $database->getConnection();
    }

    public function salvar(Usuario $usuario): Usuario
    {
        
        $u = $usuario->props();

        $id = $u['id'];
        $nome = $u['nome'];
        $email = $u['email'];
        $password = $u['senha'] ?? null;

        $sql = "
            INSERT INTO users (id, nome, email, password) 
            VALUES (:id, :nome, :email, :password)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'nome' => $nome,
            'email' => $email,
            'password' => $password,
        ]);

        return $usuario;
    }

    public function obterPorEmail(string $email): ?Usuario
    {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data === false) {
            return null;
        }

        return new Usuario([
            'id' => $data['id'],
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => $data['password']
        ]);
    }
}
