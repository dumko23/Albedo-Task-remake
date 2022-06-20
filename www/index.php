<?php

use App\core\Request;
use App\core\Router;

require __DIR__ . '/vendor/autoload.php';
require 'source/core/bootstrap.php';

Router::load('source/routes.php')
    ->redirect(
        Request::getUri($_SERVER['REQUEST_URI']),
        Request::getRequestMethod()
    );