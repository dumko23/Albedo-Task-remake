<?php

namespace App\core;

class View
{
    public function showView($view, $data = ''){
        if($data){
            extract($data);
        }

        return require $view;
    }
}