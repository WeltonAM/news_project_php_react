<?php

namespace Core\Tests\Mocks;

use Core\Domain\Shared\ProvedorCriptografia;

class ProvedorCriptografiaMock implements ProvedorCriptografia
{
    /**
     * Criptografa uma senha com um valor fixo.
     *
     * @param string $senha
     * @return string 
     */
    public function criptografar(string $senha): string
    {
        // Retorna uma senha criptografada fixa para testes
        return "$2a$12$2Wn08lE/gzq9VihLoMSVbe7fdAoCOMg6uVE3RQaJnEJc5Wa7eXuly";
    }

    /**
     * Compara a senha em texto plano com uma senha criptografada fixa.
     *
     * @param string $senha
     * @param string $senhaCriptografada 
     * @return bool
     */
    public function comparar(string $senha, string $senhaCriptografada): bool
    {
        return $senha === "!Senha123";
    }
}
