<?php

use App\core\Application;

$membersCount = Application::get('database')
    ->getFromDB(
        'memberId',
        Application::get('config')['database']['dbAndTable']
    );
echo count($membersCount);