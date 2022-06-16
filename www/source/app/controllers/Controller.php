<?php

namespace App\app\controllers;

class Controller
{
    public function main(): string
    {
        return  'source/views/pages/main.php';
    }

    public function members(): string
    {
        return  'source/views/pages/members.php';
    }

    public function getMembersCount(): string
    {
        return 'source/views/pages/membersCount.php';
    }

    public function get404(): string
    {
        return  'source/views/pages/_404.php';
    }
}