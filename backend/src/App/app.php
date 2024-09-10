<?php

use Core\App\Adapters\User\LoginUsuarioController;
use Core\App\External\Auth\ProvedorJWT;
use Core\App\External\Auth\ProvedorBcrypt;
use Core\Domain\User\Service\LoginUsuario;
use Core\App\External\DataBase\RepositorioUsuarioMySQL;

use Slim\Factory\AppFactory;
use Slim\Middleware\BodyParsingMiddleware;

require __DIR__ . '/../../init.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware(); 

$provedorToken = new ProvedorJWT($_ENV['JWT_SECRET']);
$provedorCriptografia = new ProvedorBcrypt();
$repositorioUsuario = new RepositorioUsuarioMySQL();

$loginUsuario = new LoginUsuario($repositorioUsuario, $provedorCriptografia);
$loginUsuarioController = new LoginUsuarioController($loginUsuario, $provedorToken);

// ----------------------------------------- ROTAS ABSTRATAS
$app->post('/login', [$loginUsuarioController, 'login']);

$app->run();
