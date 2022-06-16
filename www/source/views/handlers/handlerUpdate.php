<?php

namespace App\views\handlers;

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

$this->model->updateAdditionalInfo($this->getConfig(), $data, $uploadFile, $basename);

