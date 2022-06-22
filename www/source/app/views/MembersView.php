<?php

namespace App\app\views;

use App\core\View;

class MembersView extends View
{
    public static function createViewPath($page){
        return "source/views/pages/{$page}.php";
    }

    public static function createHandlerPath($file){
        return "source/app/controllers/handlers/{$file}.php";
    }
}