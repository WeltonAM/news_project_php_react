<?php

namespace Tests\Domain\Shared;

use Core\Domain\Shared\Id;
use PHPUnit\Framework\TestCase;

class IdTest extends TestCase
{
    public function testCriacaoDeIdAleatorio()
    {
        $id = new Id();
        $this->assertNotEmpty($id->__toString());
    }

    public function testCriacaoDeIdComUuidValido()
    {
        $uuid = 'e0b7b016-f6d6-48e0-a6f6-79b4dba1a3e4';
        $id = new Id($uuid);
        $this->assertEquals($uuid, (string) $id);
    }

    public function testIdInvalidoLancaExcecao()
    {
        $this->expectException(\Exception::class);
        new Id('id-invalido');
    }

    public function testComparacaoDeIds()
    {
        $id1 = new Id();
        $id2 = new Id((string) $id1);
        $id3 = new Id();

        $this->assertTrue($id1->equals($id2));
        $this->assertFalse($id1->equals($id3));
    }
}
