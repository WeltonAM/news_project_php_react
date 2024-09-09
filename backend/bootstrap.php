<?php

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/vendor/autoload.php';

$host = $_ENV['APP_HOST'];
$port = $_ENV['APP_PORT'];

passthru("php -S $host:$port -t src/public");
