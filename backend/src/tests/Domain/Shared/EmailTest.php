<?php

namespace Core\Tests\Domain\Shared;

use PHPUnit\Framework\TestCase;
use Core\Domain\Shared\Email;
use InvalidArgumentException;

class EmailTest extends TestCase
{
    public function testEmailValido()
    {
        $email = 'test@example.com';
        $objeto = new Email($email);
        $this->assertEquals($email, $objeto->getEmail());
    }

    public function testEmailInvalido()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(json_encode([
            ['codigo' => 'EMAIL_INVALIDO', 'valor' => 'invalid-email', 'atributo' => null, 'objeto' => null, 'extras' => []]
        ]));

        $email = 'invalid-email';
        new Email($email);
    }
}
