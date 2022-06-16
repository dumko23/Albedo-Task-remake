<?php

$router->get('', 'pageController@main');
$router->get('members', 'pageController@members');
$router->get('get', 'pageController@getMembersCount');
$router->post('send', 'handleController@send');
$router->post('update', 'handleController@update');