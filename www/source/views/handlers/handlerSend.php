<?php

namespace App\views\handlers;

use App\core\Application;

$data = $_POST["data"];



$result = Application::get('membersModel')
    ->registerNewMember(
        Application::get('config'),
        $data
    );


echo $result;
