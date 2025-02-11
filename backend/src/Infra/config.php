<?php

require_once __DIR__ . '/../../init.php';

return [

    'default' => $_ENV['DB_CONNECTION'],

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => $_ENV['DATABASE_URL'] ?? null,
            'database' => $_ENV['DB_DATABASE'] ?? (__DIR__ . '/../../database/database.sqlite'),
            'prefix' => '',
            'foreign_key_constraints' => $_ENV['DB_FOREIGN_KEYS'] ?? true,
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'database' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => $_ENV['MYSQL_ATTR_SSL_CA'] ?? null,
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => $_ENV['DATABASE_URL'] ?? null,
            'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
            'port' => $_ENV['DB_PORT'] ?? '5432',
            'database' => $_ENV['DB_DATABASE'] ?? 'forge',
            'username' => $_ENV['DB_USERNAME'] ?? 'forge',
            'password' => $_ENV['DB_PASSWORD'] ?? '',
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => $_ENV['DATABASE_URL'] ?? null,
            'host' => $_ENV['DB_HOST'] ?? 'localhost',
            'port' => $_ENV['DB_PORT'] ?? '1433',
            'database' => $_ENV['DB_DATABASE'] ?? 'forge',
            'username' => $_ENV['DB_USERNAME'] ?? 'forge',
            'password' => $_ENV['DB_PASSWORD'] ?? '',
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

    ],

    'migrations' => 'migrations',

    'redis' => [

        'client' => $_ENV['REDIS_CLIENT'] ?? 'phpredis',

        'options' => [
            'cluster' => $_ENV['REDIS_CLUSTER'] ?? 'redis',
            'prefix' => $_ENV['REDIS_PREFIX'] ?? 'laravel_database_',
        ],

        'default' => [
            'url' => $_ENV['REDIS_URL'] ?? null,
            'host' => $_ENV['REDIS_HOST'] ?? '127.0.0.1',
            'password' => $_ENV['REDIS_PASSWORD'] ?? null,
            'port' => $_ENV['REDIS_PORT'] ?? '6379',
            'database' => $_ENV['REDIS_DB'] ?? '0',
        ],

        'cache' => [
            'url' => $_ENV['REDIS_URL'] ?? null,
            'host' => $_ENV['REDIS_HOST'] ?? '127.0.0.1',
            'password' => $_ENV['REDIS_PASSWORD'] ?? null,
            'port' => $_ENV['REDIS_PORT'] ?? '6379',
            'database' => $_ENV['REDIS_CACHE_DB'] ?? '1',
        ],
    ],
];
