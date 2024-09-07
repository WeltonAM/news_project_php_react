<?php

namespace Core\Tests\Domain\Shared;

use PHPUnit\Framework\TestCase;
use Core\Domain\Shared\NomePessoa;
use Exception;

class NomePessoaTest extends TestCase
{
    public function testDeveLancarErroAoCriarNomeVazio()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(json_encode([
            ['codigo' => 'VAZIO', 'valor' => '', 'atributo' => 'nome', 'objeto' => 'NomePessoa', 'extras' => []],
            ['codigo' => 'TAMANHO_PEQUENO', 'valor' => '', 'atributo' => 'nome', 'objeto' => 'NomePessoa', 'extras' => ['min' => 4]],
            ['codigo' => 'CARACTERES_INVALIDOS', 'valor' => '', 'atributo' => 'nome', 'objeto' => 'NomePessoa', 'extras' => []],
            ['codigo' => 'SOBRENOME_INVALIDO', 'valor' => '', 'atributo' => 'nome', 'objeto' => 'NomePessoa', 'extras' => []],
        ]));
    
        new NomePessoa('');
    }    

    public function testDeveLancarErroAoCriarNomeMenorQue3Caracteres()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(json_encode([
            ['codigo' => 'TAMANHO_PEQUENO', 'valor' => 'L Z', 'atributo' => 'nome', 'objeto' => 'NomePessoa', 'extras' => ['min' => 4]]
        ]));

        new NomePessoa('L Z');
    }

    public function testDeveLancarErroAoCriarNomeMaiorQue120Caracteres()
    {
        $this->expectException(Exception::class);
        $nomeGigante = 'Pedro de Alcântara João Carlos Leopoldo Salvador Bibiano Francisco Xavier de Paula Leocádio Miguel Gabriel Rafael Gonzaga de Bragança e Habsburgo';
        $this->expectExceptionMessage(json_encode([
            ['codigo' => 'TAMANHO_GRANDE', 'valor' => $nomeGigante, 'atributo' => 'nome', 'objeto' => 'NomePessoa', 'extras' => ['max' => 120]]
        ]));

        new NomePessoa($nomeGigante);
    }

    public function testDeveLancarErroAoCriarNomeSemSobrenome()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(json_encode([
            ['codigo' => 'SOBRENOME_INVALIDO', 'valor' => 'Guilherme', 'atributo' => 'nome', 'objeto' => 'NomePessoa', 'extras' => []]
        ]));

        new NomePessoa('Guilherme');
    }

    public function testDeveLancarErroAoCriarNomeComCaracteresEspeciais()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(json_encode([
            ['codigo' => 'CARACTERES_INVALIDOS', 'valor' => 'João @OOOJoao', 'atributo' => 'nome', 'objeto' => 'NomePessoa', 'extras' => []]
        ]));

        new NomePessoa('João @OOOJoao');
    }

    public function testDeveCriarNomeComDoisSobrenomes()
    {
        $nome = new NomePessoa('João Silva Pereira');
        $this->assertEquals('João Silva Pereira', $nome->getCompleto());
        $this->assertEquals('João', $nome->getPrimeiroNome());
        $this->assertEquals(['Silva', 'Pereira'], $nome->getSobrenomes());
        $this->assertEquals('Pereira', $nome->getUltimoSobrenome());
    }

    public function testDeveCriarNomeComApostrofo()
    {
        $nomeComApostrofo = "João D'Ávila";
        $nome = new NomePessoa($nomeComApostrofo);
        $this->assertEquals($nomeComApostrofo, $nome->getCompleto());
    }
}
