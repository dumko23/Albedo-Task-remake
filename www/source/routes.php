<?php

$router->get('', 'PageController@main');
$router->get('members', 'PageController@members');
$router->get('get', 'PageController@membersCount');
$router->post('send', 'HandleController@handleSend');
$router->post('update', 'HandleController@handleUpdate');