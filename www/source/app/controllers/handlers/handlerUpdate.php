<?php

namespace App\views\handlers;

use App\app\controllers\HandleController;

$data = $_POST['data'];
$result = (new HandleController())
    ->handleUpdate(
        $_FILES['photo']['name'],
        $_FILES['photo']['size'],
        $_FILES['photo']['tmp_name'],
        $data
    );
if($result !== true){
    echo $result;
}