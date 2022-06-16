<?php

namespace App;

$data = $_POST["data"];


$result = $this->model->registerNewMember($this->getConfig(), $data);


echo $result;
