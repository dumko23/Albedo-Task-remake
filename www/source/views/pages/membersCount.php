<?php

use App\core\Application;

$membersCount = Application::get('database')
    ->getMembersFromDB(
        'memberId',
        Application::get('config')['database']['dbAndTable']
    );
echo count($membersCount);