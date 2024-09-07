<?php

namespace Core\Domain\Shared;

use Core\Domain\User\Model\Usuario;

interface CasoDeUso
{
    /**
     * Executa o caso de uso.
     *
     * @param mixed $entrada 
     * @param Usuario|null $usuario 
     * @return mixed
     */
    public function executar($entrada, ?Usuario $usuario = null);
}
