<?php

namespace Core\Domain\Shared;

use Core\Domain\User\Model\Usuario;

interface RepositorioUsuario
{
    /**
     * Salva um usuário no repositório.
     *
     * @param Usuario $usuario =
     * @return Usuario =
     */
    public function salvar(Usuario $usuario): Usuario;

    /**
     * Obtém um usuário por e-mail.
     *
     * @param string $email 
     * @return Usuario|null
     */
    public function obterPorEmail(string $email): ?Usuario;
}
