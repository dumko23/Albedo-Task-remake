<?php

namespace App\core;

use App\app\controllers\Controller;
use App\app\controllers\HandleController;
use App\app\models\Model;
use App\app\views\View;
use App\core\database\PDOClass;
use App\core\database\QueryBuilder;

Application::bind('config', require 'source/config.php');
Application::bind('database', new QueryBuilder(
        PDOClass::connection(
            Application::get('config')['database']
        )
    )
);
Application::bind('views', new View());
Application::bind('model', new Model());
Application::bind('router', new Router());
Application::bind('request', new Request());
Application::bind('controller', new Controller());
Application::bind('handleController', new HandleController());