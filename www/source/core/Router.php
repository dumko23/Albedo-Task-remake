<?php

namespace App\core;


use Exception;

class Router
{
    protected array $routes = [
        'POST' => [],
        'GET' => [],
        '404' => 'controller@get404'
    ];

    public static function load($file): static
    {
        $router = new static;

        require $file;

        return $router;
    }

    public function redirect($uri, $requestMethod): array
    {
        if (array_key_exists($uri, $this->routes[$requestMethod])) {
            return explode('@', $this->routes[$requestMethod][$uri]);
        } else {
            return explode('@', $this->routes['404']);
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

    public function callAction($controller, $action){
        if (! method_exists(Application::get($controller), $action)){
            var_dump($controller, $action);
            throw new Exception("{$controller} does not respond to the {$action} action");
        }
        if($action === 'send' || $action === 'update'){
            return require Application::get($controller)->$action();
        }
        $result = Application::get($controller)->$action();
        return Application::get('views')->showView($result);
    }
}