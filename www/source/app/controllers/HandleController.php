<?php

namespace App\app\controllers;

use App\core\Controller;

class HandleController extends Controller
{
    public function send(): string
    {
        return $this->returnHandlerPath('send');
    }

    public function update(): string
    {
        return $this->returnHandlerPath('update');
    }
}