<?php

namespace App\app\views;

use App\core\View;

class MembersView extends View
{
    public function createViewPath($page){
        return "source/views/pages/{$page}.php";
    }

    public function createHandlerPath($file){
        return "source/views/handlers/{$file}.php";
    }
}