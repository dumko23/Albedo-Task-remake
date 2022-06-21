<?php

namespace App\core;

use Exception;
use App\app\controllers\PageController;
use App\app\controllers\HandleController;

class Router
{
    protected array $routes = [
        'POST' => [],
        'GET' => [],
        '404' => 'pageController@page404'
    ];

    public static function load($file): static
    {
        $router = new static;

        require $file;

        return $router;
    }

    public function redirect($uri, $requestMethod)
    {
        if (array_key_exists($uri, $this->routes[$requestMethod])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestMethod][$uri])
            );
        } else {
            return $this->callAction(
                ...explode('@', $this->routes['404'])
            );
        }
    }

    public function get($uri, $controller): void
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller): void
    {
        $this->routes['POST'][$uri] = $controller;
    }

    protected function callAction($controller, $action)
    {
        $controller = "App\app\controllers\\$controller";
        if (!method_exists($controller, $action)) {
            var_dump($controller, $action);
            (new PageController())->page404();
            throw new Exception("{$controller} does not respond to the {$action} action");
        }

        if ($action === 'send' || $action === 'update') {
            return require (new $controller)->$action();
        }
        $result = (new $controller())->$action();
        return (new View)->showView($result);
    }
}