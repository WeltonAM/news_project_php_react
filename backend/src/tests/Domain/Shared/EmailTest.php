<?php

namespace Core\Tests\Domain\Shared;

use PHPUnit\Framework\TestCase;
use Core\Domain\Shared\Email;
use Exception;

class EmailTest extends TestCase
{
    public function testEmailValido()
    {
        $email = 'test@example.com';
        $objeto = new Email($email);
        $this->assertEquals($email, $objeto->getValor());
    }

    public function testEmailVazio()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(json_encode([
            ['codigo' => 'EMAIL_INVALIDO', 'valor' => '', 'atributo' => 'email', 'objeto' => 'EMAIL', 'extras' => []]
        ]));
        
        $email = '';
        $objeto = new Email($email);
        $this->assertEquals($email, $objeto->getValor());
    }

    public function testEmailInvalido()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(json_encode([
            ['codigo' => 'EMAIL_INVALIDO', 'valor' => 'invalid-email', 'atributo' => 'email', 'objeto' => 'EMAIL', 'extras' => []]
        ]));

        $email = 'invalid-email';
        new Email($email);
    }
}
