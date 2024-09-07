<?php

namespace Core\Domain\Shared;

use Exception;

class SenhaForte
{
    private string $valor;

    /**
     * SenhaForte constructor.
     *
     * @param string $valor
     * @param string|null $atributo
     * @param string|null $objeto
     * @throws Exception
     */
    public function __construct(string $valor = "", ?string $atributo = null, ?string $objeto = null)
    {
        $this->valor = $valor;
        $this->validarSenha($valor, $atributo, $objeto);
    }

    /**
     * Valida se a senha é forte.
     *
     * @param string $valor
     * @param string|null $atributo
     * @param string|null $objeto
     * @throws Exception
     */
    private function validarSenha(string $valor, ?string $atributo = null, ?string $objeto = null): void
    {
        Validador::valor($valor, $atributo, $objeto)
            ->naoNulo()
            ->senhaForte()
            ->lancarSeErro();
    }

    /**
     * Verifica se a senha fornecida é válida.
     *
     * @param string $senha
     * @return bool
     */
    public static function isValida(string $senha): bool
    {
        return Validador::valor($senha)
            ->senhaForte()
            ->getValido();
    }

    /**
     * Retorna o valor da senha.
     *
     * @return string
     */
    public function getValor(): string
    {
        return $this->valor;
    }
}
