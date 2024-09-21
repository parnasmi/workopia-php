<?php

$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingsController@index');
$router->post('/listings', 'ListingsController@store');
$router->get('/listings/create', 'ListingsController@create');
$router->get('/listings/{id}', 'ListingsController@show');
