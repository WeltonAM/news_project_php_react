<?php

namespace Core\Tests\Domain\User;

use PHPUnit\Framework\TestCase;
use Core\Domain\User\Service\CadastrarUsuario;
use Core\Domain\User\Model\Usuario;
use Core\Tests\Mock\RepositorioUsuarioMock;
use Core\Tests\Mock\ProvedorCriptografiaMock;
use Core\Tests\Data\UsuarioBuilder;

class CadastrarUsuarioTest extends TestCase
{
    private RepositorioUsuarioMock $repositorio;
    private ProvedorCriptografiaMock $provedorCripto;

    protected function setUp(): void
    {
        $this->repositorio = new RepositorioUsuarioMock();
        $this->provedorCripto = new ProvedorCriptografiaMock();
    }

    public function testDeveCadastrarUsuarioComSucesso()
    {
        $nomeCompleto = "Fulano da Silva";
        $email = "fulano.silva@zmail.com";
        $senha = '!Senha123';

        $usuario = UsuarioBuilder::criar()
            ->comNome($nomeCompleto)
            ->comEmail($email)
            ->comSenha('$2a$12$2Wn08lE/gzq9VihLoMSVbe7fdAoCOMg6uVE3RQaJnEJc5Wa7eXuly') 
            ->agora();

        $casoDeUso = new CadastrarUsuario($this->repositorio, $this->provedorCripto);
        $casoDeUso->executar(['nome' => $usuario->getNome()->getCompleto(), 'email' => $usuario->getEmail()->getValor(), 'senha' => $usuario->getSenha()->getValor()]);

        $usuarioEsperado = new Usuario([
            'nome' => $nomeCompleto,
            'email' => $email,
            'senha' => '$2a$12$2Wn08lE/gzq9VihLoMSVbe7fdAoCOMg6uVE3RQaJnEJc5Wa7eXuly'
        ]);

        $this->assertInstanceOf(Usuario::class, $usuarioEsperado);
        $this->assertEquals($email, $usuarioEsperado->getEmail()->getValor());
    }

    public function testDeveLancarExcecaoUsuarioJaExistente()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(json_encode(['codigo' => 'USUARIO_JA_EXISTE', 'valor' => 'fulano.silva@zmail.com', 'atributo' => 'email', 'objeto' => 'Usuario', 'extras' => []]));

        $nomeCompleto = "Fulano da Silva";
        $email = "fulano.silva@zmail.com";
        $senha = '!Senha123';

        $usuario1 = UsuarioBuilder::criar()
            ->comNome($nomeCompleto)
            ->comEmail($email)
            ->comSenha('$2a$12$2Wn08lE/gzq9VihLoMSVbe7fdAoCOMg6uVE3RQaJnEJc5Wa7eXuly') 
            ->agora();

        $casoDeUso = new CadastrarUsuario($this->repositorio, $this->provedorCripto);
        $casoDeUso->executar(['nome' => $usuario1->getNome()->getCompleto(), 'email' => $usuario1->getEmail()->getValor(), 'senha' => $usuario1->getSenha()->getValor()]);

        $usuario2 = UsuarioBuilder::criar()
            ->comNome($nomeCompleto)
            ->comEmail($email)
            ->comSenha('$2a$12$2Wn08lE/gzq9VihLoMSVbe7fdAoCOMg6uVE3RQaJnEJc5Wa7eXuly') 
            ->agora();

        $casoDeUso = new CadastrarUsuario($this->repositorio, $this->provedorCripto);
        $casoDeUso->executar(['nome' => $usuario2->getNome()->getCompleto(), 'email' => $usuario2->getEmail()->getValor(), 'senha' => $usuario2->getSenha()->getValor()]);
    }
}
