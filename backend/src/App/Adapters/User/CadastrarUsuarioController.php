<?php

namespace Core\App\Adapters\User;

use Core\Domain\User\Service\CadastrarUsuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CadastrarUsuarioController
{
    private CadastrarUsuario $casoDeUso;

    public function __construct(CadastrarUsuario $casoDeUso)
    {
        $this->casoDeUso = $casoDeUso;
    }

    public function cadastrar(Request $request, Response $response, array $args): Response
    {
        try {
            $body = $request->getParsedBody();
            $nome = $body['nome'];
            $email = $body['email'];
            $senha = $body['senha'];

            $this->casoDeUso->executar(['nome' => $nome, 'email' => $email, 'senha' => $senha]);

            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
            
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['erros' => $this->tratarErros($e)]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }

    private function tratarErros(\Exception $e): array
    {
        return ['mensagem' => $e->getMessage()];
    }
}
