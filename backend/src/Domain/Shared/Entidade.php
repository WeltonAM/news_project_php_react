<?php

namespace Core\Domain\Shared;

abstract class Entidade
{
    protected Id $id;
    private array $props;

    public function __construct(array $props)
    {
        $this->id = new Id($props['id'] ?? null);
        $this->props = array_merge($props, ['id' => $this->id->valor()]);
    }

    public function igual(Entidade $entidade): bool
    {
        return $this->id->igual($entidade->id);
    }

    public function diferente(Entidade $entidade): bool
    {
        return !$this->igual($entidade);
    }

    /**
     * Clona a entidade com novas propriedades.
     *
     * @param array $novasProps 
     * @param mixed 
     * @return static Retorna uma nova instância da entidade clonada.
     */
    public function clone(array $novasProps, ...$args): self
    {
        $classe = get_class($this);
        return new $classe(array_merge($this->props, $novasProps), ...$args);
    }

    /**
     * Retorna as propriedades da entidade.
     *
     * @return array
     */
    public function getProps(): array
    {
        return $this->props;
    }
}
