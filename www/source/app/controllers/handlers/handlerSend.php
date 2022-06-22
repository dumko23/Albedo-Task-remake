<?php

namespace App\views\handlers;

use App\app\models\MembersModel;
use App\core\Application;

$data = $_POST["data"];
$model = new MembersModel();
$result = $model
    ->registerNewMember(
        Application::get('config'),
        $data
    );

echo $result;
