<?php

namespace App\core;

class Request
{

    public static function getUri($request): string
    {
        return trim($request, '/');
    }

    public static function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}