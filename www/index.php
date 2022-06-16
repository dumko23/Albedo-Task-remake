<?php

use App\core\Application;

require __DIR__ . '/vendor/autoload.php';
require 'source/core/bootstrap.php';


Application::get('router')
    ->callAction(...Application::get('router')
        ->load('source/routes.php')
        ->redirect(
            Application::get('request')
                ->getUri($_SERVER['REQUEST_URI']),
            Application::get('request')
                ->getRequestMethod()
        )
    );