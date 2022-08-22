<?php

require_once __DIR__ .'/vendor/autoload.php';
//$app = new \app\core\Application();
// OR
use app\core\Application;


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [

    'db' => [

        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(__DIR__, $config); // dirname(__DIR__) => returns the path of the project


$app-> db-> applyMigrations();
