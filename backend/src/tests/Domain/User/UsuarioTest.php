<?php

namespace Core\Tests\Domain\User;

use PHPUnit\Framework\TestCase;
use Core\Domain\Usuario;
use Core\Domain\Shared\NomePessoa;
use Core\Domain\Shared\Email;
use Core\Domain\Shared\SenhaHash;
use Core\Tests\Utils\Teste;
use Core\Tests\Data\UsuarioBuilder;

class UsuarioTest extends TestCase
{
    public function testDeveCriarUmUsuario()
    {
        $nomeCompleto = "Fulano da Silva";
        $email = "fulano.silva@zmail.com";

        $usuario = UsuarioBuilder::criar()
            ->comNome($nomeCompleto)
            ->comEmail($email)
            ->agora();

        $this->assertEquals($nomeCompleto, $usuario->getNome()->getCompleto());
        $this->assertEquals($email, $usuario->getEmail()->getValor());
        $this->assertInstanceOf(SenhaHash::class, $usuario->getSenha());
    }

    public function testDeveCriarUmUsuarioSemSenha()
    {
        $usuario = UsuarioBuilder::criar()
            ->semSenha()
            ->agora();

        $this->assertNull($usuario->getSenha());
    }

    public function testDeveLancarErroQuandoNomeNaoForInformado()
    {
        $this->expectException(\Exception::class);

        UsuarioBuilder::criar()
            ->semNome()
            ->agora();
    }

    public function testDeveLancarErroQuandoNomeNaoTiverSobrenome()
    {
        $this->expectException(\Exception::class);

        UsuarioBuilder::criar()
            ->comNome("Pedro")
            ->agora();
    }

    public function testDeveLancarErroQuandoUsuarioEstiverSemEmail()
    {
        $this->expectException(\Exception::class);

        UsuarioBuilder::criar()
            ->semEmail()
            ->agora();
    }
}
