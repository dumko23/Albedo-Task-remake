<?php

namespace App\core;

use App\app\views\MembersView;

class Controller
{
    public function returnPagePath($page): string
    {
        $path = Application::get('config')['pagePath'];
        return $path['path'] . $page . $path['ext'];
    }

}