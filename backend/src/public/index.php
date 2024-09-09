<?php

require_once __DIR__ . '/../../vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__DIR__ . '/..')->load();

require_once __DIR__ . '/../Infra/config.php';

require_once __DIR__ . '/../App/app.php';

runApp();
