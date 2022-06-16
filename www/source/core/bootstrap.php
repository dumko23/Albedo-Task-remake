<?php

namespace App\core;


Application::bind('config', require 'source/config.php');

Application::bind('database', new QueryBuilder(
        PDOClass::connection(Application::get('config')['database'])
    )
);

Application::bind('view', new View());

Application::bind('router', new Router());
Application::bind('request', new Request());
Application::bind('controller', new Controller());