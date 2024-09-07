<?php

namespace Core\Tests\Domain\Shared;

use Core\Domain\Shared\TextoSimples;
use PHPUnit\Framework\TestCase;
use Exception;

class TextoSimplesTest extends TestCase
{
    public function testTextoSimplesValido()
    {
        $texto = "Texto aceitável";
        $minimo = 5;
        $maximo = 16;

        $textoSimples = new TextoSimples($texto, $minimo, $maximo, 'texto', 'TextoSimples');
        $this->assertEquals($texto, $textoSimples->getCompleto());
    }

    public function testTextoSimplesInvalido()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(json_encode([
            ['codigo' => 'TAMANHO_PEQUENO', 'valor' => 'text', 'atributo' => 'texto', 'objeto' => 'TextoSimples', 'extras' => ['min' => 5]]
        ]));

        $texto = "text";
        $minimo = 5;
        $maximo = 20;

        new TextoSimples($texto, $minimo, $maximo, 'texto', 'TextoSimples');
    }

    public function testTextoSimplesComTamanhoExcedente()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(json_encode([
            ['codigo' => 'TAMANHO_GRANDE', 'valor' => 'Texto muito longo para o limite', 'atributo' => 'texto', 'objeto' => 'TextoSimples', 'extras' => ['max' => 20]]
        ]));

        $texto = "Texto muito longo para o limite";
        $minimo = 5;
        $maximo = 20;

        new TextoSimples($texto, $minimo, $maximo, 'texto', 'TextoSimples');
    }

    public function testTextoSimplesComTextoValido()
    {
        $texto = "Texto aceitável";
        $minimo = 5;
        $maximo = 16;

        $textoSimples = new TextoSimples($texto, $minimo, $maximo, 'texto', 'TextoSimples');
        $this->assertEquals($texto, $textoSimples->getCompleto());
    }
}
