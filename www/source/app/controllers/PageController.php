<?php

namespace App\app\controllers;

use App\core\Application;
use App\core\Controller;
use App\core\Model;

class PageController extends Controller
{
    public function main(): array
    {

        return [
            'path' => $this->returnPagePath('main'),
            'data' => '',
        ];
    }

    public function members(): array
    {
        return [
            'path' => $this->returnPagePath('members'),
            'data' => $this->showMembers(),
        ];
    }

    public function showMembers()
    {
        return Model::getData('photo, firstName, lastName, email, subject',
                  Application::get('config')['database']['dbAndTable']);
    }

    public function membersCount()
    {
        return [
            'path' => $this->returnPagePath('membersCount'),
            'data' => $this->showMembers(),
        ];
    }

    public function page404()
    {
        return [
            'path' => $this->returnPagePath('page404'),
            'data' => '',
        ];
    }
}