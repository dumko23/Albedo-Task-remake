<?php

$router->get('', 'controller@main');
$router->get('members', 'controller@members');
$router->get('get', 'controller@getMembersCount');
$router->post('send', 'handleController@send');
$router->post('update', 'handleController@update');