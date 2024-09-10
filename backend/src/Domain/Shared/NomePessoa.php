<?php

namespace Core\Domain\Shared;

use Exception;

class NomePessoa
{
    private string $nome;

    /**
     * NomePessoa constructor.
     *
     * @param string|null $nome
     * @param string|null $atributo
     * @param string|null $objeto
     * 
     * @throws Exception
     */
    public function __construct(?string $nome = null, ?string $atributo = null, ?string $objeto = null)
    {
        $this->validarNome($nome);
        $this->nome = $nome;
    }

    /**
     * Valida o nome da pessoa.
     *
     * @param string $nome
     * @throws Exception
     */
    private function validarNome(?string $nome): void
    {
        $validador = Validador::valor($nome, 'nome', 'NomePessoa')
            ->naoVazio('VAZIO')
            ->naoNulo('VAZIO')
            ->tamanhoMaiorOuIgualQue(4, 'TAMANHO_PEQUENO')
            ->tamanhoMenorOuIgualQue(120, 'TAMANHO_GRANDE')
            ->regex("/^[a-zA-ZÀ-ÿ' ]+$/u", 'CARACTERES_INVALIDOS');

        if (count(explode(' ', $nome)) < 2) {
            $validador->adicionarErro('SOBRENOME_INVALIDO');
        }

        $validador->lancarSeErro();
    }

    public function getCompleto(): string
    {
        return $this->nome;
    }

    public function getPrimeiroNome(): string
    {
        $partes = explode(' ', $this->nome);
        return $partes[0];
    }

    public function getSobrenomes(): array
    {
        $partes = explode(' ', $this->nome);
        array_shift($partes);
        return $partes;
    }

    public function getUltimoSobrenome(): string
    {
        $sobrenomes = $this->getSobrenomes();
        return end($sobrenomes);
    }
}
