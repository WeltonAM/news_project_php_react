<?php

use Core\App\Adapters\User\UsuarioController;

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/users' && $requestMethod === 'GET') {
    if (isset($_GET['email'])) {
        $controller = new UsuarioController();
        $controller->obterUsuarioPorEmail($_GET['email']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Email não fornecido']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint não encontrado']);
}
