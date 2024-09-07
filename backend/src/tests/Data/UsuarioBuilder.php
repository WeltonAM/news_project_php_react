<?php

namespace Core\Tests\Data;

use Faker\Factory as FakerFactory;
use Core\Domain\User\Model\Usuario;

class UsuarioBuilder
{
    private array $props;

    private function __construct(array $props)
    {
        $this->props = $props;
    }

    /**
     * Cria uma nova instância do Builder com valores padrão.
     *
     * @return UsuarioBuilder
     */
    public static function criar(): UsuarioBuilder
    {
        $faker = FakerFactory::create();
        $nome = self::ajustarNome($faker->name);

        return new UsuarioBuilder([
            'nome' => $nome,
            'email' => $faker->email,
            'senha' => '$2a$12$l4uqYBbpysvi.FY24ZXia.6r8b1W91W2Ekru69xSZnKXdY5QJ9o/m', // Senha hash padrão
        ]);
    }

    /**
     * Define o ID para o usuário.
     *
     * @param string $id
     * @return UsuarioBuilder
     */
    public function comId(string $id): UsuarioBuilder
    {
        $this->props['id'] = $id;
        return $this;
    }

    /**
     * Remove o ID do usuário.
     *
     * @return UsuarioBuilder
     */
    public function semId(): UsuarioBuilder
    {
        unset($this->props['id']);
        return $this;
    }

    /**
     * Define o nome para o usuário.
     *
     * @param string $nome
     * @return UsuarioBuilder
     */
    public function comNome(string $nome): UsuarioBuilder
    {
        $this->props['nome'] = $nome;
        return $this;
    }

    /**
     * Remove o nome do usuário.
     *
     * @return UsuarioBuilder
     */
    public function semNome(): UsuarioBuilder
    {
        unset($this->props['nome']);
        return $this;
    }

    /**
     * Define o email para o usuário.
     *
     * @param string $email
     * @return UsuarioBuilder
     */
    public function comEmail(string $email): UsuarioBuilder
    {
        $this->props['email'] = $email;
        return $this;
    }

    /**
     * Remove o email do usuário.
     *
     * @return UsuarioBuilder
     */
    public function semEmail(): UsuarioBuilder
    {
        unset($this->props['email']);
        return $this;
    }

    /**
     * Define a senha para o usuário.
     *
     * @param string $senha
     * @return UsuarioBuilder
     */
    public function comSenha(string $senha): UsuarioBuilder
    {
        $this->props['senha'] = $senha;
        return $this;
    }

    /**
     * Remove a senha do usuário.
     *
     * @return UsuarioBuilder
     */
    public function semSenha(): UsuarioBuilder
    {
        unset($this->props['senha']);
        return $this;
    }

    /**
     * Cria uma nova instância de Usuario com as propriedades configuradas.
     *
     * @return Usuario
     */
    public function agora(): Usuario
    {
        return new Usuario($this->props);
    }

    private static function ajustarNome(string $nome): string
    {
        return preg_replace('/[^a-zA-ZÀ-ÿ\' ]/', '', $nome);
    }
}
