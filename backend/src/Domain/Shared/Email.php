<?php

namespace Core\Domain\Shared;

use InvalidArgumentException;

class Email
{
    private string $email;

    /**
     * Email constructor.
     *
     * @param string $email
     * @throws InvalidArgumentException
     */
    public function __construct(string $email)
    {
        $this->validarEmail($email);
        $this->email = $email;
    }

    /**
     * Valida se o e-mail está em um formato correto.
     *
     * @param string $email
     * @throws InvalidArgumentException
     */
    private function validarEmail(string $email): void
    {
        $validador = Validador::valor($email)
            ->email();

        if ($validador->getInvalido()) {
            throw new InvalidArgumentException(json_encode($validador->getErros()));
        }
    }

    /**
     * Retorna o e-mail.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Representação em string do e-mail.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->email;
    }
}
