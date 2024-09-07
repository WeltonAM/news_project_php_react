<?php

namespace Core\Domain\Shared;

use Exception;

class Email
{
    private string $email;

    /**
     * Email constructor.
     *
     * @param string $email
     * @throws Exception
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
     * @throws Exception
     */
    private function validarEmail(string $email): void
    {
        $validador = Validador::valor($email, 'email', 'EMAIL')
            ->email()
            ->lancarSeErro();
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
