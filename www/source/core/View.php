<?php

namespace App\core;

class View
{
    public function showView($view){
        return require $view;
    }
}