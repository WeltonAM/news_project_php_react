<?php

namespace Core\Tests\Domain\Shared;

use PHPUnit\Framework\TestCase;
use Core\Domain\Shared\Data;
use InvalidArgumentException;

class DataTest extends TestCase
{
    public function testDataValida()
    {
        $data = '2024-09-07T12:34:56.789Z';
        $objeto = new Data($data);
        $this->assertEquals($data, $objeto->getData());
    }

    public function testDataInvalida()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(json_encode([
            ['codigo' => 'DATA_INVALIDA', 'valor' => 'invalid-data', 'atributo' => null, 'objeto' => null, 'extras' => []]
        ]));

        $data = 'invalid-data';
        new Data($data);
    }
}
