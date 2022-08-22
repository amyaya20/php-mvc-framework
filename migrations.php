<?php

require_once __DIR__ .'/vendor/autoload.php';
//$app = new \amohd12\phpmvc\Application();
// OR
use amohd12\phpmvc\Application;


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
