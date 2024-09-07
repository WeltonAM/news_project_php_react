<?php

namespace Core\Domain\Error;

interface ErroValidacao
{
    public function getCodigo(): string;
    public function getObjeto(): ?string;
    public function getAtributo(): ?string;
    public function getValor();
    public function getExtras(): array;
}
