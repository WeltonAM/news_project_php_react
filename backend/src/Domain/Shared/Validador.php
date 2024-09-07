<?php

namespace Core\Domain\Shared;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Core\Domain\Error\ErroValidacao;

class Validador
{
    private $valor;
    private ?string $atributo;
    private ?string $objeto;
    private array $erros = [];

    private function __construct($valor, ?string $atributo = null, ?string $objeto = null)
    {
        $this->valor = $valor;
        $this->atributo = $atributo;
        $this->objeto = $objeto;
    }

    public static function valor($valor, ?string $atributo = null, ?string $objeto = null): self
    {
        return new self($valor, $atributo, $objeto);
    }

    public static function lancarErro(string $erro): void
    {
        throw new InvalidArgumentException(json_encode(['codigo' => $erro]));
    }

    public static function combinar(Validador ...$validadores): ?array
    {
        $errosFiltrados = array_merge(...array_map(fn($v) => $v->getErros(), $validadores));
        return !empty($errosFiltrados) ? $errosFiltrados : null;
    }

    public function nulo(string $erro = "NAO_NULO"): self
    {
        if ($this->valor !== null && $this->valor !== '') {
            $this->adicionarErro($erro);
        }
        return $this;
    }

    public function naoNulo(string $erro = "NULO"): self
    {
        if ($this->valor === null || $this->valor === '') {
            $this->adicionarErro($erro);
        }
        return $this;
    }

    public function naoNegativo(string $erro = "VALOR_NEGATIVO"): self
    {
        if (!is_numeric($this->valor) || $this->valor < 0) {
            $this->adicionarErro($erro);
        }
        return $this;
    }

    public function naoVazio(string $erro = "VAZIO"): self
    {
        if (is_array($this->valor)) {
            if (count($this->valor) === 0) {
                $this->adicionarErro($erro);
            }
        } elseif (trim((string)$this->valor) === '') {
            $this->adicionarErro($erro);
        }
        return $this;
    }

    public function tamanhoMenorQue(int $tamanhoMaximo, string $erro = "TAMANHO_GRANDE"): self
    {
        if (strlen((string)$this->valor) >= $tamanhoMaximo) {
            $this->adicionarErro($erro, ['max' => $tamanhoMaximo]);
        }
        return $this;
    }

    public function tamanhoMenorOuIgualQue(int $tamanhoMaximo, string $erro = "TAMANHO_GRANDE"): self
    {
        if (strlen((string)$this->valor) > $tamanhoMaximo) {
            $this->adicionarErro($erro, ['max' => $tamanhoMaximo]);
        }
        return $this;
    }

    public function tamanhoMaiorQue(int $tamanhoMinimo, string $erro = "TAMANHO_PEQUENO"): self
    {
        if (strlen((string)$this->valor) <= $tamanhoMinimo) {
            $this->adicionarErro($erro, ['min' => $tamanhoMinimo]);
        }
        return $this;
    }

    public function tamanhoMaiorOuIgualQue(int $tamanhoMinimo, string $erro = "TAMANHO_PEQUENO"): self
    {
        if (strlen((string)$this->valor) < $tamanhoMinimo) {
            $this->adicionarErro($erro, ['min' => $tamanhoMinimo]);
        }
        return $this;
    }

    public function menorQue(float $max, string $erro = "MAIOR"): self
    {
        if ($this->valor >= $max) {
            $this->adicionarErro($erro, ['max' => $max]);
        }
        return $this;
    }

    public function menorOuIgualQue(float $max, string $erro = "MAIOR"): self
    {
        if ($this->valor > $max) {
            $this->adicionarErro($erro, ['max' => $max]);
        }
        return $this;
    }

    public function maiorQue(float $min, string $erro = "MENOR"): self
    {
        if ($this->valor <= $min) {
            $this->adicionarErro($erro, ['min' => $min]);
        }
        return $this;
    }

    public function maiorOuIgualQue(float $min, string $erro = "MENOR"): self
    {
        if ($this->valor < $min) {
            $this->adicionarErro($erro, ['min' => $min]);
        }
        return $this;
    }

    public function uuid(string $erro = "ID_INVALIDO"): self
    {
        if (!Uuid::isValid($this->valor)) {
            $this->adicionarErro($erro);
        }
        return $this;
    }

    public function url(string $erro = "URL_INVALIDA"): self
    {
        if (!filter_var($this->valor, FILTER_VALIDATE_URL)) {
            $this->adicionarErro($erro);
        }
        return $this;
    }

    public function email(string $erro = "EMAIL_INVALIDO"): self
    {
        if (!filter_var($this->valor, FILTER_VALIDATE_EMAIL)) {
            $this->adicionarErro($erro);
        }
        return $this;
    }

    public function senhaHash(string $erro = "HASH_INVALIDO"): self
    {
        $regex = '/^\$2[ayb]\$[0-9]{2}\$[A-Za-z0-9\.\/]{53}$/';
        if (!preg_match($regex, $this->valor)) {
            $this->adicionarErro($erro);
        }
        return $this;
    }

    public function senhaForte(string $erro = "SENHA_FRACA"): self
    {
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/';
        if (!preg_match($regex, $this->valor)) {
            $this->adicionarErro($erro);
        }
        return $this;
    }

    public function regex(string $regex, string $erro): self
    {
        if (!preg_match($regex, $this->valor)) {
            $this->adicionarErro($erro);
        }
        return $this;
    }

    public function tipoInvalido(string $erro): self
    {
        $this->adicionarErro($erro);
        return $this;
    }

    public function dataValida(string $erro = "DATA_INVALIDA"): self
    {
        $regex = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.\d{3}Z$/';
        if (!preg_match($regex, $this->valor)) {
            $this->adicionarErro($erro);
        }
        return $this;
    }

    public function statusValido(string $erro = "STATUS_INVALIDO"): self
    {
        $valoresValidos = ["consolidado", "cancelado", "pendente"];
        if (!in_array($this->valor, $valoresValidos)) {
            $this->adicionarErro($erro);
        }
        return $this;
    }

    public function tipoValido(string $erro = "TIPO_INVALIDO"): self
    {
        $valoresValidos = ["receita", "despesa"];
        if (!in_array($this->valor, $valoresValidos)) {
            $this->adicionarErro($erro);
        }
        return $this;
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

    public function getErros(): array
    {
        return $this->erros;
    }

    public function getValido(): bool
    {
        return empty($this->erros);
    }

    public function getInvalido(): bool
    {
        return !$this->getValido();
    }

    public function lancarSeErro(): void
    {
        if (!$this->getValido()) {
            throw new InvalidArgumentException(json_encode($this->erros));
        }
    }

    private function jaTemErro(array $erro): bool
    {
        foreach ($this->erros as $e) {
            if ($e['codigo'] === $erro['codigo'] &&
                $e['valor'] === $erro['valor'] &&
                $e['atributo'] === $erro['atributo'] &&
                $e['objeto'] === $erro['objeto']) {
                return true;
            }
        }
        return false;
    }
}
