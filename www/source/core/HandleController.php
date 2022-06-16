<?php

namespace App\core;

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