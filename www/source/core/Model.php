<?php

namespace App\core;

class Model
{
    public function addMember($data): void
    {
        Application::get('database')->insertMemberToDB(
            Application::get('config')['database']['dbAndTable'],
            $data
        );
    }

    public function updateMember($data, $whereStatement, $match): void
    {
        Application::get('database')->update(
            Application::get('config')['database']['dbAndTable'],
            $data,
            $whereStatement,
            $match
        );
    }
}