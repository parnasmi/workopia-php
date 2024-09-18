<?php

$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingsController@index');
$router->get('/listings/create', 'ListingsController@create');
$router->get('/listing', 'ListingsController@show');
// $router->get('/404', 'controllers/error/404.php');
