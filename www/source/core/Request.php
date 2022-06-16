<?php

namespace App\core;

class Request
{

    public function getUri($request): string
    {
        return trim($request, '/');
    }

    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}