<?php

namespace App\core;

use Exception;

class Router
{
    protected array $routes = [
        'POST' => [],
        'GET' => [],
        '404' => 'PageController@page404'
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
        $controllerName = $controller;
        $controller = "App\app\controllers\\$controller";
        $controller = new $controller;
        if (!method_exists($controller, $action)) {
            throw new Exception("{$controller} does not respond to the {$action} action");
        }
        if ($controllerName === 'HandleController') {
            echo $controller->$action();
            exit();
        }
        $result = $controller->$action();
        return (new View)->showView($result);
    }
}