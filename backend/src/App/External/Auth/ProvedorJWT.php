<?php

namespace Core\App\External\Auth;

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class ProvedorJWT
{
    private string $segredo;

    public function __construct(string $segredo)
    {
        $this->segredo = $segredo;
    }

    public function gerar(array|string $payload): string
    {
        return JWT::encode($payload, $this->segredo, 'HS256');
    }

    public function validar(string $token): array|object
    {
        try {
            return JWT::decode($token, new Key($this->segredo, 'HS256'));
        } catch (\Exception $e) {
            throw new \RuntimeException('Token inválido ou expirado', 0, $e);
        }
    }
}
