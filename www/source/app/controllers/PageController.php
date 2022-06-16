<?php

namespace App\app\controllers;

use App\core\Application;
use App\core\Controller;

class PageController extends Controller
{
    public function main(): string
    {
        return $this->returnPagePath('main');
    }

    public function members(): string
    {
        return $this->returnPagePath('members');
    }

    public function membersCount(): string
    {
        return $this->returnPagePath('membersCount');
    }

    public function page404(): string
    {
        return $this->returnPagePath('page404');
    }
}