<?php

namespace Core\Tests\Domain\Shared;

use Core\Domain\Shared\SenhaForte;
use PHPUnit\Framework\TestCase;
use Exception;

class SenhaForteTest extends TestCase
{
    public function testSenhaForteValida()
    {
        $senha = 'Senha@2024';
        $senhaForte = new SenhaForte($senha);
        $this->assertEquals($senha, $senhaForte->getValor());
    }

    public function testSenhaForteInvalida()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(json_encode([
            ['codigo' => 'SENHA_FRACA', 'valor' => 'senha', 'atributo' => null, 'objeto' => null, 'extras' => []]
        ]));

        $senha = 'senha';
        new SenhaForte($senha);
    }

    public function testIsValidaComSenhaForte()
    {
        $senha = 'Senha@2024';
        $this->assertTrue(SenhaForte::isValida($senha));
    }

    public function testIsValidaComSenhaFraca()
    {
        $senha = 'senha';
        $this->assertFalse(SenhaForte::isValida($senha));
    }
}
