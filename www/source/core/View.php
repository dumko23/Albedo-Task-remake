<?php

namespace App\core;

class View
{
    public function showView($view){
        if($view['data']){
            $data = $view['data'];
            extract($data);
        }

        return require $view['path'];
    }
}