<?php

$router->get('', 'pageController@main');
$router->get('members', 'pageController@members');
$router->get('get', 'pageController@membersCount');
$router->post('send', 'handleController@send');
$router->post('update', 'handleController@update');