<?php

namespace App\app\controllers;

use App\app\models\MembersModel;
use App\core\Application;
use App\core\Controller;

class HandleController extends Controller
{
    public function send(): string
    {
        return $this->returnHandlerPath('handlerSend');
    }

    public function update(): string
    {
        return $this->returnHandlerPath('handlerUpdate');
    }

    public function handleUpdate($fileName, $fileSizeRow, $fileTmp, $data){
        $uploadDir = 'uploads/';
        $basename = basename($fileName);
        $uploadFile ='source/' . $uploadDir . $basename;

        $is_check = true;
        if ($basename){
            $array = explode('.', $basename);
            $ext = end($array);
            $is_check = in_array($ext, ['jpg', 'png', 'jpeg'], true);
        }

        if($fileSizeRow > 5242880){
            $fileSize = number_format($fileSizeRow/1048576, 2, ',', ' ');
            return "Max file size is 10 MB. Your is {$fileSize} MB";

        } else if ($is_check === false){
            return "Available extensions is .jpg, .png, .jpeg. You uploaded .$ext file";
        }

        if ($basename && !move_uploaded_file($fileTmp, $uploadFile)) {
            return 'Ошибка при загрузке файла';
        }
        $model = new MembersModel();
        $model->updateAdditionalInfo(Application::get('config'), $data, $uploadFile, $basename);
        return true;
    }
}