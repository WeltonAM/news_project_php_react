<?php

namespace Core\Tests\Domain\Shared;

use Core\Domain\Shared\SenhaHash;
use PHPUnit\Framework\TestCase;
use Exception;

class SenhaHashTest extends TestCase
{
    public function testSenhaHashValida()
    {
        // Um exemplo de hash bcrypt válido
        $hash = '$2y$10$eIm5FkD11YVVxjsoUOM3VuaR1WVEh8MOXyOF7v/6B2ei8ebShTj1m'; 

        $senhaHash = new SenhaHash($hash);
        $this->assertEquals($hash, $senhaHash->getValor());
    }

    public function testSenhaHashInvalida()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(json_encode([
            ['codigo' => 'HASH_INVALIDO', 'valor' => 'invalidhash', 'atributo' => null, 'objeto' => null, 'extras' => []]
        ]));

        $hash = 'invalidhash';
        new SenhaHash($hash);
    }

    public function testIsValidaComHashValido()
    {
        $hash = '$2y$10$eIm5FkD11YVVxjsoUOM3VuaR1WVEh8MOXyOF7v/6B2ei8ebShTj1m'; 
        $this->assertTrue(SenhaHash::isValida($hash));
    }

    public function testIsValidaComHashInvalido()
    {
        $hash = 'invalidhash';
        $this->assertFalse(SenhaHash::isValida($hash));
    }
}
