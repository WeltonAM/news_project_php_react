<?php

namespace Core\App\Adapters\User;

use Core\App\External\DataBase\RepositorioUsuarioMySQL;

class UsuarioController
{
    private RepositorioUsuarioMySQL $repositorioUsuario;

    public function __construct()
    {
        $this->repositorioUsuario = new RepositorioUsuarioMySQL();
    }

    public function obterUsuarioPorEmail($email)
    {
        $usuario = $this->repositorioUsuario->obterPorEmail($email);

        if ($usuario === null) {
            http_response_code(404);
            echo json_encode(['error' => 'Usuário não encontrado']);
            return;
        }

        echo json_encode([
            'nome' => $usuario->getNome()->getCompleto(),
            'email' => $usuario->getEmail()->getValor(),
        ]);
    }
}
