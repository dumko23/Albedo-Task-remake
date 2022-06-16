<?php

namespace App\core;

use App\app\controllers\PageController;
use App\app\controllers\HandleController;
use App\app\models\MembersModel;
use App\app\views\MembersView;
use App\core\database\PDOClass;
use App\core\database\QueryBuilder;

Application::bind('config', require 'source/config.php');
Application::bind('database', new QueryBuilder(
        PDOClass::connection(
            Application::get('config')['database']
        )
    )
);
Application::bind('views', new MembersView());
Application::bind('membersModel', new MembersModel());
Application::bind('router', new Router());
Application::bind('request', new Request());
Application::bind('pageController', new PageController());
Application::bind('handleController', new HandleController());