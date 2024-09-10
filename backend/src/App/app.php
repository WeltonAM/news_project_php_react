<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

use Core\App\Adapters\User\CadastrarUsuarioController;
use Core\App\Adapters\User\LoginUsuarioController;

use Core\App\External\Auth\ProvedorBcrypt;
use Core\App\External\Auth\ProvedorJWT;
use Core\App\External\DataBase\RepositorioUsuarioMySQL;

use Core\Domain\User\Service\LoginUsuario;
use Core\Domain\User\Service\CadastrarUsuario;

use Slim\Factory\AppFactory;
use Slim\Middleware\BodyParsingMiddleware;
use GuzzleHttp\Psr7\Utils;

require __DIR__ . '/../../init.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware(); 

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$provedorToken = new ProvedorJWT($_ENV['JWT_SECRET']);
$provedorCriptografia = new ProvedorBcrypt();
$repositorioUsuario = new RepositorioUsuarioMySQL();

$cadastrarUsuario = new CadastrarUsuario($repositorioUsuario, $provedorCriptografia);
$cadastrarUsuarioController = new CadastrarUsuarioController($cadastrarUsuario);

$loginUsuario = new LoginUsuario($repositorioUsuario, $provedorCriptografia);
$loginUsuarioController = new LoginUsuarioController($loginUsuario, $provedorToken);

// ----------------------------------------- ROTAS ABSTRATAS
$app->get('/', function ($request, $response) {
    $body = json_encode(['mensagem' => 'Bem vindo ao nosso API']);
    $stream = Utils::streamFor($body);
    return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->withBody($stream);
});
$app->post('/cadastrar', [$cadastrarUsuarioController, 'cadastrar']);
$app->post('/login', [$loginUsuarioController, 'login']);

$app->run();
