<?php

namespace App\app\controllers;

use App\app\models\MembersModel;
use App\core\Application;
use App\core\Controller;

class HandleController extends Controller
{
    public function handleSend(): bool|string
    {
        $data = $_POST["data"];
        $model = new MembersModel();
        return $model
            ->registerNewMember(
                Application::get('config'),
                $data
            );
    }

    public function handleUpdate(): bool|array|string
    {
        $data = $_POST['data'];

        $uploadDir = 'uploads/';
        $basename = basename($_FILES['photo']['name']);
        $uploadFile = 'source/' . $uploadDir . $basename;

        $is_check = true;
        if ($basename) {
            $array = explode('.', $basename);
            $ext = end($array);
            $is_check = in_array($ext, ['jpg', 'png', 'jpeg'], true);
        }

        if ($_FILES['photo']['size'] > 5242880) {
            $fileSize = number_format($_FILES['photo']['size'] / 1048576, 2, ',', ' ');
            return "Max file size is 10 MB. Your is {$fileSize} MB";

        } else if ($is_check === false) {
            return "Available extensions is .jpg, .png, .jpeg. You uploaded .$ext file";
        }

        if ($basename && !move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            return 'Ошибка при загрузке файла';
        }

        $model = new MembersModel();
        $result = $model->updateAdditionalInfo(Application::get('config'), $data, $uploadFile, $basename);
        if ($result === true) {
            exit();
        } else {
            return $result;
        }
    }

    public function membersCount(): string
    {
        $data = MembersModel::showMembersData();
        return json_encode([
            'membersCount' => count($data),
        ]);
    }
}