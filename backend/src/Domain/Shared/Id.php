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
     * @param string|null $uuid
     * @throws Exception
     */
    public function __construct(?string $uuid = null)
    {
        if ($uuid === null) {
            $this->uuid = Uuid::uuid4();
        } else {
            if (!Uuid::isValid($uuid)) {
                throw new Exception("ID inválido, deve ser um UUID.");
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
     * @param Id $id
     * @return bool
     */
    public function equals(Id $id): bool
    {
        return $this->uuid->equals($id->uuid);
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
}
