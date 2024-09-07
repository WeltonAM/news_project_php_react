<?php

namespace Core\Domain\Shared;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Exception;

class Id
{
    /**
     * @var UuidInterface
     */
    private UuidInterface $uuid;

    /**
     * Construtor de Id.
     *
     * @param string|null $uuid ID opcional no formato de string.
     * @param string|null $atributo Nome do atributo associado ao ID (opcional).
     * @param string|null $objeto Nome do objeto ao qual o ID pertence (opcional).
     * 
     * @throws Exception Lança uma exceção se o ID fornecido não for um UUID válido.
     */
    public function __construct(?string $uuid = null, ?string $atributo = null, ?string $objeto = null)
    {
        if ($uuid === null) {
            // Cria um novo UUID se não for fornecido um
            $this->uuid = Uuid::uuid4();
        } else {
            if (!Uuid::isValid($uuid)) {
                $mensagemErro = "ID inválido, deve ser um UUID.";
                
                if ($atributo !== null && $objeto !== null) {
                    $mensagemErro = sprintf("ID inválido para o atributo '%s' no objeto '%s'. Deve ser um UUID.", $atributo, $objeto);
                }

                throw new Exception($mensagemErro);
            }

            $this->uuid = Uuid::fromString($uuid);
        }
    }

    /**
     * Retorna o ID como uma string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    /**
     * Compara este Id com outro para verificar igualdade.
     *
     * @param Id $id Instância de Id a ser comparada.
     * @return bool True se os IDs forem iguais, caso contrário, False.
     */
    public function igual(Id $id): bool
    {
        return $this->uuid->equals($id->getUuid());
    }

    /**
     * Retorna o UUID interno.
     *
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * Retorna o valor do ID como string.
     *
     * @return string
     */
    public function valor(): string
    {
        return $this->uuid->toString();
    }
}
