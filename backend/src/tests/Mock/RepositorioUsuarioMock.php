<?php

namespace Core\Tests\Mocks;

use Core\Domain\User\Model\Usuario;
use Core\Domain\Shared\RepositorioUsuario;

class RepositorioUsuarioMock implements RepositorioUsuario
{
    private array $usuarios = [];

    /**
     * Salva um usuário no repositório mock.
     *
     * @param Usuario $usuario 
     * @return Usuario 
     */
    public function salvar(Usuario $usuario): Usuario
    {
        $index = array_search($usuario->getEmail()->getValor(), array_column($this->usuarios, 'email'));

        if ($index !== false) {
            $this->usuarios[$index] = $usuario;
        } else {
            $this->usuarios[] = $usuario;
        }

        return $usuario;
    }

    /**
     * Obtém um usuário por e-mail.
     *
     * @param string $email 
     * @return Usuario|null
     */
    public function obterPorEmail(string $email): ?Usuario
    {
        foreach ($this->usuarios as $usuario) {
            if ($usuario->getEmail()->getValor() === $email) {
                return $usuario;
            }
        }

        return null;
    }
}
