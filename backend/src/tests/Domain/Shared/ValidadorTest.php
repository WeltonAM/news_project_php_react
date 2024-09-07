<?php

use PHPUnit\Framework\TestCase;
use Core\Domain\Shared\Validador;
use Ramsey\Uuid\Uuid;

class ValidadorTest extends TestCase
{
    public function testValorNulo()
    {
        $validador = Validador::valor('teste')->nulo();
        $this->assertFalse($validador->getValido());
        $this->assertNotEmpty($validador->getErros());
    }

    public function testValorNaoNulo()
    {
        $validador = Validador::valor(null)->naoNulo();
        $this->assertFalse($validador->getValido());
        $this->assertNotEmpty($validador->getErros());
    }

    public function testValorNaoNegativo()
    {
        $validador = Validador::valor(-1)->naoNegativo();
        $this->assertFalse($validador->getValido());
        $this->assertNotEmpty($validador->getErros());
    }

    public function testTamanhoMenorQue()
    {
        $validador = Validador::valor('12345')->tamanhoMenorQue(5);
        $this->assertFalse($validador->getValido());
        $this->assertNotEmpty($validador->getErros());
    }

    public function testUuidValido()
    {
        $validador = Validador::valor(Uuid::uuid4()->toString())->uuid();
        $this->assertTrue($validador->getValido());
    }

    public function testUuidInvalido()
    {
        $validador = Validador::valor('invalid-uuid')->uuid();
        $this->assertFalse($validador->getValido());
        $this->assertNotEmpty($validador->getErros());
    }

    public function testEmailValido()
    {
        $validador = Validador::valor('example@example.com')->email();
        $this->assertTrue($validador->getValido());
    }

    public function testEmailInvalido()
    {
        $validador = Validador::valor('invalid-email')->email();
        $this->assertFalse($validador->getValido());
        $this->assertNotEmpty($validador->getErros());
    }

    public function testCombinarValidadores()
    {
        $validador1 = Validador::valor('')->naoNulo();
        $validador2 = Validador::valor(10)->menorQue(5);

        $erros = Validador::combinar($validador1, $validador2);

        $this->assertNotEmpty($erros);
        $this->assertCount(2, $erros);
    }

    public function testLancarErro()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(json_encode(['codigo' => 'ERRO_EXEMPLO']));

        Validador::lancarErro('ERRO_EXEMPLO');
    }
    
    public function adicionarErro(string $codigoErro, array $extras = []): self
    {
        $erro = [
            'codigo' => $codigoErro,
            'valor' => $this->valor,
            'atributo' => $this->atributo,
            'objeto' => $this->objeto,
            'extras' => $extras
        ];

        if (!$this->jaTemErro($erro)) {
            $this->erros[] = $erro;
        }
        return $this;
    }
}
