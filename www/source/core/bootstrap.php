<?php

namespace App\core;

use App\core\database\PDOClass;
use App\core\database\QueryBuilder;

Application::bind('config', require 'source/config.php');
Application::bind('database', new QueryBuilder(
        PDOClass::connection(
            Application::get('config')['database']
        )
    )
);