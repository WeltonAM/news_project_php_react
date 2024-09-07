<?php

namespace Core\Domain\Shared;

use Exception;

class Data
{
    private string $data;

    /**
     * Data constructor.
     *
     * @param string $data
     * @throws Exception
     */
    public function __construct(string $data)
    {
        $this->validarData($data);
        $this->data = $data;
    }

    /**
     * Valida se a data está no formato correto.
     *
     * @param string $data
     * @throws Exception
     */
    private function validarData(string $data): void
    {
        $validador = Validador::valor($data, 'data', 'DATA')
            ->naoNulo('DATA_NULA')
            ->dataValida('DATA_INVALIDA')
            ->lancarSeErro();
    }

    /**
     * Retorna a data.
     *
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * Representação em string da data.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->data;
    }
}
