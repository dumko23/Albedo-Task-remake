<?php

namespace App\app\controllers;

class HandleController
{
    public function send(): string
    {
        return 'source/views/handlers/handlerSend.php';
    }

    public function update(): string
    {
        return 'source/views/handlers/handlerUpdate.php';
    }
}