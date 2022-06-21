<?php

$router->get('', 'PageController@main');
$router->get('members', 'PageController@members');
$router->get('get', 'PageController@membersCount');
$router->post('send', 'HandleController@send');
$router->post('update', 'HandleController@update');