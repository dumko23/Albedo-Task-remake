<?php

namespace App\app\controllers;

use App\core\Controller;

class HandleController extends Controller
{
    public function send(): string
    {
        return $this->returnHandlerPath('handlerSend');
    }

    public function update(): string
    {
        return $this->returnHandlerPath('handlerUpdate');
    }
}