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
        $nome = $usuario->getNome()->getCompleto();
        $email = $usuario->getEmail()->getValor();
        $password = $usuario->getSenha() ? $usuario->getSenha()->getValor() : null;

        if ($usuario->getId()->valor()) {
            $sql = "
                UPDATE users 
                SET nome = :nome, email = :email, password = :password 
                WHERE id = :id
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'id' => $usuario->getId()->valor(),
                'nome' => $nome,
                'email' => $email,
                'password' => $password,
            ]);
        } else {
            $sql = "
                INSERT INTO users (nome, email, password) 
                VALUES (:nome, :email, :password)
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'nome' => $nome,
                'email' => $email,
                'password' => $password,
            ]);

            $usuario->setId($this->pdo->lastInsertId());
        }

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
