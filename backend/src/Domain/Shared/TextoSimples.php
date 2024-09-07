<?php

namespace Core\Domain\Shared;

use Exception;

class TextoSimples
{
    private string $completo;

    /**
     * TextoSimples constructor.
     *
     * @param string $completo
     * @param int $minimo
     * @param int $maximo
     * @param string|null $atributo
     * @param string|null $objeto
     * @throws Exception
     */
    public function __construct(
        string $completo,
        int $minimo,
        int $maximo,
        ?string $atributo = null,
        ?string $objeto = null
    ) {
        $this->completo = trim($completo);
        $this->validarTexto($this->completo, $minimo, $maximo, $atributo, $objeto);
    }

    /**
     * Valida o texto conforme as regras estabelecidas.
     *
     * @param string $completo
     * @param int $minimo
     * @param int $maximo
     * @param string|null $atributo
     * @param string|null $objeto
     * @throws Exception
     */
    private function validarTexto(
        string $completo,
        int $minimo,
        int $maximo,
        ?string $atributo = null,
        ?string $objeto = null
    ): void {
        Validador::valor($completo, $atributo, $objeto)
            ->naoVazio()
            ->tamanhoMaiorOuIgualQue($minimo)
            ->tamanhoMenorOuIgualQue($maximo)
            ->lancarSeErro();
    }

    /**
     * Retorna o valor completo do texto.
     *
     * @return string
     */
    public function getCompleto(): string
    {
        return $this->completo;
    }
}
