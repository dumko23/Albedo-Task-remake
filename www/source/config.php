<?php

namespace App;

use PDO;
use Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

return [
    'database' => [
        'dbAndTable' => $_ENV['MYSQL_DATABASE'] . '.' . $_ENV['MYSQL_TABLE'],
        'user' => $_ENV['MYSQL_USER'],
        'password' => $_ENV['MYSQL_PASSWORD'],
        'name' => 'mysql:host=' . $_ENV['MYSQL_HOSTNAME'] . ';port:' . $_ENV['MYSQL_PORT'] . ';',
        'db' => $_ENV['MYSQL_DATABASE'],
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => 2
        ],
    ],
    'shareMessage' => [
        'message' => 'Check out this Meetup with SoCal AngularJS!',
    ],
    'pagePath' => [
        'path' => 'source/views/pages/',
        'ext' => '.php',
    ]
];