<?php

namespace Core\Tests\Domain\User;

use PHPUnit\Framework\TestCase;
use Core\Domain\User\Service\LoginUsuario;
use Core\Domain\User\Model\Usuario;
use Core\Tests\Mock\RepositorioUsuarioMock;
use Core\Tests\Mock\ProvedorCriptografiaMock;
use Core\Tests\Data\UsuarioBuilder;

class LoginUsuarioTest extends TestCase
{
    private RepositorioUsuarioMock $repositorio;
    private ProvedorCriptografiaMock $provedorCripto;

    protected function setUp(): void
    {
        $this->repositorio = new RepositorioUsuarioMock();
        $this->provedorCripto = new ProvedorCriptografiaMock();
    }

    public function testDeveRetornarUsuarioValido()
    {
        $nomeCompleto = "Fulano da Silva";
        $email = "fulano.silva@zmail.com";
        $senha = '!Senha123';

        $usuario = UsuarioBuilder::criar()
            ->comNome($nomeCompleto)
            ->comEmail($email)
            ->comSenha('$2a$12$2Wn08lE/gzq9VihLoMSVbe7fdAoCOMg6uVE3RQaJnEJc5Wa7eXuly') 
            ->agora();

        $this->repositorio->salvar($usuario);

        $casoDeUso = new LoginUsuario($this->repositorio, $this->provedorCripto);
        $resultado = $casoDeUso->executar(['email' => $usuario->getEmail()->getValor(), 'senha' => $senha]);

        $this->assertInstanceOf(Usuario::class, $resultado);
        $this->assertEquals($email, $resultado->getEmail()->getValor());
        $this->assertNull($resultado->getSenha()); 
    }

    public function testDeveLancarExcecaoUsuarioNaoEncontrado()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(json_encode(['codigo' => 'USUARIO_NAO_EXISTE']));

        $email = 'naoexiste@email.com.br';
        $senha = '123456789';

        $this->repositorio->obterPorEmail($email);

        $casoDeUso = new LoginUsuario($this->repositorio, $this->provedorCripto);
        $casoDeUso->executar(['email' => $email, 'senha' => $senha]);
    }

    public function testDeveLancarExcecaoSenhaIncorreta()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(json_encode(['codigo' => 'SENHA_INCORRETA']));

        $nomeCompleto = "Fulano da Silva";
        $email = "fulano.silva@zmail.com";
        $senha = '!Senha12';

        $usuario = UsuarioBuilder::criar()
            ->comNome($nomeCompleto)
            ->comEmail($email)
            ->agora();

        $this->repositorio->salvar($usuario);

        $casoDeUso = new LoginUsuario($this->repositorio, $this->provedorCripto);
        $casoDeUso->executar(['email' => $email, 'senha' => $senha]);
    }
}
