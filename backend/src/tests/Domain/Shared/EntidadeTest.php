<?php

namespace Core\Tests\Domain\Shared;

use Core\Domain\Shared\Entidade;
use Core\Domain\Shared\Id;
use PHPUnit\Framework\TestCase;

class EntidadeTeste extends Entidade
{
    public function __construct(array $props)
    {
        parent::__construct($props);
    }
}

class EntidadeTest extends TestCase
{
    public function testDeveCalcularIgualdadeParaTrueQuandoEntidadesPossuemMesmoId()
    {
        $id = (new Id())->valor();
        $entidade1 = new EntidadeTeste(['id' => $id]);
        $entidade2 = new EntidadeTeste(['id' => $id]);

        $this->assertTrue($entidade1->igual($entidade2));
    }

    public function testDeveCalcularIgualdadeParaFalseQuandoEntidadesPossuemIdsDiferentes()
    {
        $id1 = (new Id())->valor();
        $id2 = (new Id())->valor();
        $entidade1 = new EntidadeTeste(['id' => $id1]);
        $entidade2 = new EntidadeTeste(['id' => $id2]);

        $this->assertFalse($entidade1->igual($entidade2));
        $this->assertTrue($entidade1->diferente($entidade2));
    }

    public function testDeveClonarEntidade()
    {
        $id = (new Id())->valor();
        $entidade = new EntidadeTeste([
            'id' => $id,
            'nome' => 'Fulaninho',
            'idade' => 20,
        ]);

        $clone = $entidade->clone(['idade' => 30]);

        $this->assertEquals($entidade->igual($clone), true);
        $this->assertEquals($clone->getProps()['nome'], $entidade->getProps()['nome']);
        $this->assertEquals($clone->getProps()['idade'], 30);
    }
}
