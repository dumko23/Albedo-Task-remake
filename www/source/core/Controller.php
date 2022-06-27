<?php

namespace App\core;

class Controller
{
    public function returnPagePath($page): string
    {
        $path = Application::get('config')['pagePath'];
        return $path['path'] . $page . $path['ext'];
    }

}