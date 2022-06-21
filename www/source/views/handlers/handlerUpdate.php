<?php

namespace App\views\handlers;

use App\core\Application;

$data = $_POST['data'];

$uploadDir = 'uploads/';
$basename = basename($_FILES['photo']['name']);
$uploadFile ='source/' . $uploadDir . $basename;

$is_check = true;
if ($basename){
    $array = explode('.', $basename);
    $ext = end($array);
    $is_check = in_array($ext, ['jpg', 'png', 'jpeg'], true);
}


if($_FILES['photo']['size'] > 5242880){
    $fileSize = number_format($_FILES['photo']['size']/1048576, 2, ',', ' ');
    echo "Max file size is 10 MB. Your is {$fileSize} MB";
    exit();
} else if ($is_check === false){
    echo "Available extensions is .jpg, .png, .jpeg. You uploaded .$ext file";
    exit();
}

if ($basename && !move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
    echo 'Ошибка при загрузке файла';
}




Application::get('membersModel')->updateAdditionalInfo(Application::get('config'), $data, $uploadFile, $basename);

