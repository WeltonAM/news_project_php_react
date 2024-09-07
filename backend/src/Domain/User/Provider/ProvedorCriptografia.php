<?php

namespace Core\Domain\Shared;

interface ProvedorCriptografia
{
    /**
     * Criptografa uma senha.
     *
     * @param string $senha 
     * @return string 
     */
    public function criptografar(string $senha): string;

    /**
     * Compara uma senha em texto plano com uma senha criptografada.
     *
     * @param string $senha 
     * @param string $senhaCriptografada 
     * @return bool 
     */
    public function comparar(string $senha, string $senhaCriptografada): bool;
}
