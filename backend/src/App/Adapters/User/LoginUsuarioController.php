<?php

namespace Core\App\Adapters\User;

use Core\Domain\User\Service\LoginUsuario;
use Core\App\External\Auth\ProvedorJWT;
use Core\Domain\Shared\Validador;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class LoginUsuarioController
{
    private LoginUsuario $casoDeUso;
    private ProvedorJWT $provedorToken;

    public function __construct(LoginUsuario $casoDeUso, ProvedorJWT $provedorToken)
    {
        $this->casoDeUso = $casoDeUso;
        $this->provedorToken = $provedorToken;
    }

    public function login(Request $request, Response $response, array $args): Response
    {
        try {
            $body = $request->getParsedBody();
            $email = $body['email'];
            $senha = $body['senha'];

            $usuario = $this->casoDeUso->executar(['email' => $email, 'senha' => $senha]);

            $token = $this->provedorToken->gerar([
                'id' => $usuario->props()['id'],
                'nome' => $usuario->props()['nome'],
                'email' => $usuario->props()['email'],
            ]);

            $response->getBody()->write(json_encode(['token' => $token]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

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
