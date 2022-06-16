<?php

namespace App\views\handlers;

use App\core\Application;

$data = $_POST['data'];

$uploadDir = 'uploads/';
$basename = basename($_FILES['photo']['name']);
$uploadFile ='source/' . $uploadDir . $basename;

echo '<pre>';
if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
    echo "Файл корректен и был успешно загружен.\n";
} else {
    echo 'Ошибка при загрузке файла';
}
echo '</pre>';

Application::get('membersModel')->updateAdditionalInfo(Application::get('config'), $data, $uploadFile, $basename);

