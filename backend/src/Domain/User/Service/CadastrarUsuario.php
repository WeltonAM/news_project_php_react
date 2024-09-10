<?php

namespace Core\Domain\User\Service;

use Core\Domain\User\Model\Usuario;
use Core\Domain\Shared\CasoDeUso;
use Core\Domain\User\Provider\RepositorioUsuario;
use Core\Domain\User\Provider\ProvedorCriptografia;
use Core\Domain\Shared\Validador;
use Core\Domain\Shared\Email;
use Core\Domain\Shared\NomePessoa;
use Core\Domain\Shared\SenhaForte;

class CadastrarUsuario implements CasoDeUso
{
    private RepositorioUsuario $repositorio;
    private ProvedorCriptografia $provedorCripto;

    public function __construct(RepositorioUsuario $repositorio, ProvedorCriptografia $provedorCripto)
    {
        $this->repositorio = $repositorio;
        $this->provedorCripto = $provedorCripto;
    }

    /**
     * Executa o cadastro do usuário.
     *
     * @param array $entrada 
     * @param Usuario|null $usuario 
     * @return void
     * @throws \Exception 
     */
    public function executar($entrada, ?Usuario $usuario = null): void
    {
        $nome = new NomePessoa($entrada['nome'], 'nome', 'NomePessoa');
        $email = new Email($entrada['email'], 'email', 'Email');
        $senha = new SenhaForte($entrada['senha'], 'senha', 'SenhaForte');

        $senhaCripto = $this->provedorCripto->criptografar($senha->getValor());

        $usuarioExistente = $this->repositorio->obterPorEmail($email->getValor());
        
        if ($usuarioExistente !== null) {
            Validador::valor($usuarioExistente->getEmail()->getValor(), 'email', 'Usuario')
                ->nulo('USUARIO_JA_EXISTE')
                ->lancarSeErro();
        }

        $usuario = new Usuario([
            'nome' => $nome->getCompleto(),
            'email' => $email->getValor(),
            'senha' => $senhaCripto,
        ]);

        $this->repositorio->salvar($usuario);
    }
}
