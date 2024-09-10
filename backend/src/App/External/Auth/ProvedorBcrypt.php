<?php

namespace Core\App\External\Auth;

use Core\Domain\User\Provider\ProvedorCriptografia;

class ProvedorBcrypt implements ProvedorCriptografia
{
    
    public function criptografar(string $senha): string
    {
        return password_hash($senha, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    public function comparar(string $senha, string $senhaCriptografada): bool
    {
        return password_verify($senha, $senhaCriptografada);
    }
}
