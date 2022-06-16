<?php

use App\core\Application;

$membersCount = Application::get('database')->getMembersFromDB();
echo count($membersCount);