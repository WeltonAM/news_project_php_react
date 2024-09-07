<?php

namespace Core\Domain\Shared;

use Exception;

class SenhaHash
{
    private string $valor;

    /**
     * SenhaHash constructor.
     *
     * @param string $valor
     * @param string|null $atributo
     * @param string|null $objeto
     * @throws Exception
     */
    public function __construct(string $valor, ?string $atributo = null, ?string $objeto = null)
    {
        $this->valor = $valor;
        $this->validarHash($valor, $atributo, $objeto);
    }

    /**
     * Valida se o hash da senha é válido.
     *
     * @param string $valor
     * @param string|null $atributo
     * @param string|null $objeto
     * @throws Exception
     */
    private function validarHash(string $valor, ?string $atributo = null, ?string $objeto = null): void
    {
        Validador::valor($valor, $atributo, $objeto)
            ->senhaHash()
            ->lancarSeErro();
    }

    /**
     * Verifica se o hash da senha fornecido é válido.
     *
     * @param string $hash
     * @return bool
     */
    public static function isValida(string $hash): bool
    {
        return Validador::valor($hash)
            ->senhaHash()
            ->getValido();
    }

    /**
     * Retorna o valor do hash da senha.
     *
     * @return string
     */
    public function getValor(): string
    {
        return $this->valor;
    }
}
