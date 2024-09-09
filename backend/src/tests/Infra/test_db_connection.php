<?php

require_once __DIR__ . '/../../../vendor/autoload.php'; 

Dotenv\Dotenv::createImmutable(__DIR__ . '/../../..')->load();

require_once __DIR__ . '/../../Infra/config.php';

use Core\Infra\Database\Database;

try {
    $db = new Database();
    $pdo = $db->getConnection();
    echo "Conexão ao banco de dados bem-sucedida!";
} catch (Exception $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
