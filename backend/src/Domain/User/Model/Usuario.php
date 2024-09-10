<?php

namespace Core\Domain\User\Model;

use Core\Domain\Shared\Entidade;
use Core\Domain\Shared\NomePessoa;
use Core\Domain\Shared\Email;
use Core\Domain\Shared\SenhaHash;

class Usuario extends Entidade
{
    private NomePessoa $nome;
    private Email $email;
    private ?SenhaHash $senha;

    public function __construct(array $props)
    {
        parent::__construct($props);
        $this->nome = new NomePessoa($props['nome'] ?? '', 'nome', 'usuário');
        $this->email = new Email($props['email'] ?? '', 'email', 'usuário');
        $this->senha = isset($props['senha'])
            ? new SenhaHash($props['senha'], 'senha', 'usuário')
            : null;
    }

    public function props(): array
    {
        return [
            'id' => $this->id->valor(),
            'nome' => $this->nome->getCompleto(),
            'email' => $this->email->getValor(),
            'senha' => $this->senha ? $this->senha->getValor() : null,
        ];
    }

    public function semSenha(): self
    {
        return $this->clone(['senha' => null]);
    }

    public function getNome(): NomePessoa
    {
        return $this->nome;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getSenha(): ?SenhaHash
    {
        return $this->senha;
    }
}
