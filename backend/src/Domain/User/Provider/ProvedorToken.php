<?php

namespace Core\Domain\Shared;

interface ProvedorToken
{
    /**
     * Gera um token a partir de um payload.
     *
     * @param string|object $payload 
     * @return string 
     */
    public function gerar($payload): string;

    /**
     * Valida um token e retorna o payload associado.
     *
     * @param string $token 
     * @return string|object 
     */
    public function validar(string $token);
}
