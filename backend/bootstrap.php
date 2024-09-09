<?php

require 'vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__DIR__)->load();

$host = $_ENV['APP_HOST'];
$port = $_ENV['APP_PORT'];

passthru("php -S $host:$port -t src/public");
