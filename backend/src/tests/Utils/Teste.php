<?php

namespace Core\Tests\Utils;

use Core\Domain\Error\ErroValidacao;
use PHPUnit\Framework\Assert;

class Teste
{
    /**
     * Executa uma função e verifica se o erro gerado corresponde aos erros esperados.
     *
     * @param callable $fn 
     * @param ErroValidacao 
     */
    public static function comErro(callable $fn, ErroValidacao ...$erros): void
    {
        try {
            $fn();
            throw new \Exception("Deveria ter lançado um erro");
        } catch (\Throwable $e) {
            self::checarErroValidacao($e, ...$erros);
        }
    }

    /**
     * Executa uma função assíncrona e verifica se o erro gerado corresponde aos erros esperados.
     *
     * @param callable $fn 
     * @param ErroValidacao 
     */
    public static function comErroSinc(callable $fn, ErroValidacao ...$erros): void
    {
        try {
            $result = $fn();
            if ($result instanceof \Promise) {
                $result->then(
                    function () {
                        throw new \Exception("Deveria ter lançado um erro");
                    },
                    function (\Throwable $e) use ($erros) {
                        self::checarErroValidacao($e, ...$erros);
                    }
                );
            } else {
                throw new \Exception("Deveria ter lançado um erro");
            }
        } catch (\Throwable $e) {
            self::checarErroValidacao($e, ...$erros);
        }
    }

    /**
     * Verifica se o erro lançado corresponde aos erros esperados.
     *
     * @param \Throwable $e 
     * @param ErroValidacao 
     */
    private static function checarErroValidacao(\Throwable $e, ErroValidacao ...$erros): void
    {
        if (!($e instanceof ErroValidacao)) {
            throw $e; 
        }

        foreach ($erros as $i => $erro) {
            Assert::assertEquals($erro->getCodigo(), $e->getCodigo(), "Erro no código no índice $i");
            Assert::assertEquals($erro->getObjeto(), $e->getObjeto(), "Erro no objeto no índice $i");
            Assert::assertEquals($erro->getAtributo(), $e->getAtributo(), "Erro no atributo no índice $i");
            Assert::assertEquals($erro->getValor(), $e->getValor(), "Erro no valor no índice $i");
            Assert::assertEquals($erro->getExtras(), $e->getExtras(), "Erro nos extras no índice $i");
        }
    }
}
