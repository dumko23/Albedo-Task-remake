<?php

$router->get('', 'PageController@main');
$router->get('members', 'PageController@members');
$router->get('get', 'HandleController@membersCount');
$router->post('send', 'HandleController@handleSend');
$router->post('update', 'HandleController@handleUpdate');