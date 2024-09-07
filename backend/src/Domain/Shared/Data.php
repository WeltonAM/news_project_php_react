<?php

namespace Core\Domain\Shared;

use InvalidArgumentException;

class Data
{
    private string $data;

    /**
     * Data constructor.
     *
     * @param string $data
     * @throws InvalidArgumentException
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
     * @throws InvalidArgumentException
     */
    private function validarData(string $data): void
    {
        $validador = Validador::valor($data)
            ->dataValida();

        if ($validador->getInvalido()) {
            throw new InvalidArgumentException(json_encode($validador->getErros()));
        }
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
