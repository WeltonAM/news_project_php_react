<?php

namespace Core\Domain\User\Service;

use Core\Domain\User\Model\Usuario;
use Core\Domain\Shared\CasoDeUso;
use Core\Domain\User\Provider\RepositorioUsuario;
use Core\Domain\User\Provider\ProvedorCriptografia;
use Core\Domain\Shared\Validador;
use Core\Domain\Shared\Email;

class LoginUsuario implements CasoDeUso
{
    private RepositorioUsuario $repositorio;
    private ProvedorCriptografia $provedorCripto;

    public function __construct(RepositorioUsuario $repositorio, ProvedorCriptografia $provedorCripto)
    {
        $this->repositorio = $repositorio;
        $this->provedorCripto = $provedorCripto;
    }

    /**
     * Executa o login do usuário.
     *
     * @param array $entrada 
     * @param Usuario|null $usuario 
     * @return Usuario
     * @throws \Exception 
     */
    public function executar($entrada, ?Usuario $usuario = null): Usuario
    {
        if (!is_array($entrada)) {
            throw new \InvalidArgumentException('A entrada deve ser um array.');
        }

        $email = new Email($entrada['email'], 'email');
        $usuario = $this->repositorio->obterPorEmail($email->getValor());
        
        if (!$usuario) {
            Validador::lancarErro('USUARIO_NAO_EXISTE');
        }

        $senhaCorreta = $this->provedorCripto->comparar(
            $entrada['senha'],
            $usuario->getSenha()->getValor()
        );

        if (!$senhaCorreta) {
            Validador::lancarErro('SENHA_INCORRETA');
        }

        return $usuario->semSenha();
    }
}
