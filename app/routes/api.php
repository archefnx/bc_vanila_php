<?php
$router->register('/api/processes', 'App\Controllers\ProccessController@index');
$router->register('/api/processes/store', 'App\Controllers\ProccessController@store');
$router->register('/api/processes/destroy', 'App\Controllers\ProccessController@destroy');

$router->register('/api/field/store', 'App\Controllers\FieldController@store');
$router->register('/api/field/destroy', 'App\Controllers\FieldController@destroy');

$router->register('/api/type/store', 'App\Controllers\TypeController@store');
$router->register('/api/type/destroy', 'App\Controllers\TypeController@destroy');

$router->register('/api/proccess-mng/add', 'App\Controllers\ProccessManageController@addFields');
$router->register('/api/proccess-mng/get', 'App\Controllers\ProccessManageController@getFields');
