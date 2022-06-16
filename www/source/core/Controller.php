<?php

namespace App\core;

class Controller
{
    public function returnPagePath($page){
        return Application::get('views')->createViewPath($page);
    }

    public function returnHandlerPath($file){
        return Application::get('views')->createhandlerPath($file);
    }
}